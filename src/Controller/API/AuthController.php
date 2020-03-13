<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\User;
use App\Model\TokenDTO;
use App\Model\UserDTO;
use App\Service\CodeGeneratorService;
use App\Service\MailerService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function assert;

/**
 * @Rest\RouteResource(
 *     "User",
 *     pluralize=false
 * )
 * @Rest\Prefix(value="auth")
 * Class UserController
 */
class AuthController extends BaseController implements ClassResourceInterface
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        parent::__construct($serializer, $validator);
        $this->serializationGroup = ['user_details', 'user_embed'];
    }

    /**
     * @SWG\Post(
     *    operationId="login",
     *    produces={"application/json"},
     *    summary="Авторизация пользователя",
     *    description="Авторизация пользователя",
     *    tags={"AuthController"},
     *    @SWG\Parameter(
     *      name="credentials",
     *      in="body",
     *      description="JSON Payload",
     *      required=true,
     *      type="string",
     *      format="application/json",
     *      @SWG\Schema(ref=@Model(type=App\Model\UserDTO::class, groups={"login"})),
     *    ),
     *    @SWG\Response(
     *      response="200",
     *      description="Success",
     *      @SWG\Schema(
     *        type="object",
     *        @SWG\Property(property="token", type="string"),
     *        @SWG\Property(
     *          property="roles",
     *          type="array",
     *          @SWG\Items(type="string", example="ROLE_USER")
     *        ),
     *        @SWG\Property(property="refresh_token", type="string"),
     *      ),
     *    ),
     *    @SWG\Response(
     *      response="401",
     *      description="Invalid JWT token",
     *    )
     * )
     */
    public function login() : void
    {
    }

    /**
     * @SWG\Post(
     *    operationId="postUserAction",
     *    produces={"application/json"},
     *    summary="Регистрация пользователя",
     *    description="Регистрация пользователя",
     *    tags={"AuthController"},
     *    @SWG\Parameter(
     *      name="credentials",
     *      in="body",
     *      description="JSON Payload",
     *      required=true,
     *      type="string",
     *      format="application/json",
     *      @SWG\Schema(ref=@Model(type=App\Model\UserDTO::class)),
     *    ),
     *    @SWG\Response(
     *      response="200",
     *      description="Success",
     *      @SWG\Schema(
     *        type="object",
     *        @SWG\Property(property="token", type="string"),
     *        @SWG\Property(
     *          property="roles",
     *          type="array",
     *          @SWG\Items(type="string", example="ROLE_USER")
     *        ),
     *        @SWG\Property(property="refresh_token", type="string"),
     *      ),
     *    ),
     *    @SWG\Response(
     *      response="401",
     *      description="Invalid JWT token",
     *    )
     * )
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        MailerService $mailerService,
        CodeGeneratorService $codeGeneratorService,
        AuthenticationSuccessHandler $authenticationSuccessHandler
    ) : JWTAuthenticationSuccessResponse {
        $this->validateRequestData($request, UserDTO::class);
        $userDTO = $this->data;
        assert($userDTO instanceof UserDTO);
        $user = $userDTO->fromDTO();
        assert($user instanceof User);
        $user->setConfirmationCode($codeGeneratorService->getConfirmationCode($user->getSalt()));
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
        $this->persist($user);

        $mailerService->sendConfirmationMessage($user);

        return $authenticationSuccessHandler->handleAuthenticationSuccess($user);
    }

    /**
     * @SWG\Post(
     *    operationId="confirmRegistration",
     *    produces={"application/json"},
     *    summary="Подтверждение регистрации пользователя",
     *    description="Подтверждение регистрации пользователя",
     *    tags={"AuthController"},
     *   @SWG\Parameter(
     *      name="confirmationCode",
     *      in="path",
     *      description="Случайно сгенерированная строка приложением необходимая для подтверждения регистрации",
     *      required=true,
     *      type="string",
     *    ),
     *    @SWG\Response(
     *      response="200",
     *      description="success"
     *    ),
     *    @SWG\Response(
     *      response="401",
     *      description="Invalid JWT token"
     *    )
     * )
     */
    public function registerConfirm(User $user) : void
    {
        $user->setActive(true);
        $user->setConfirmationCode('');
        $this->getDoctrine()->getManager()->flush();
        $this->view(['success' => true]);
    }

    /**
     * @return mixed
     *
     * @SWG\Post(
     *    operationId="refreshToken",
     *    produces={"application/json"},
     *    summary="Обновление токена пользователя",
     *    description="Обновление токена пользователя",
     *    tags={"AuthController"},
     *    @SWG\Parameter(
     *      name="refresh_token",
     *      in="body",
     *      description="JSON Payload",
     *      required=true,
     *      type="string",
     *      format="application/json",
     *      @SWG\Schema(ref=@Model(type=App\Model\TokenDTO::class)),
     *    ),
     *    @SWG\Response(
     *      response="200",
     *      description="Success",
     *    )
     * )
     */
    public function refresh(Request $request, RefreshToken $refreshService)
    {
        $this->validateRequestData($request, TokenDTO::class);

        return $refreshService->refresh($request);
    }

    /**
     * #TODO найти готовый пример
     */
    public function passwordReset() : void
    {
    }
}
