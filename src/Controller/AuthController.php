<?php

namespace App\Controller;

use App\Model\TokenDTO;
use App\Model\UserDTO;
use App\Entity\User;
use App\Service\CodeGeneratorService;
use App\Service\MailerService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use JMS\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Rest\RouteResource(
 *     "User",
 *     pluralize=false
 * )
 * @Rest\Prefix(value="auth")
 * Class UserController
 * @package App\Controller
 */
class AuthController extends BaseController implements ClassResourceInterface
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        parent::__construct($serializer, $validator);
        $this->serializationGroup = ["user_details", "user_embed"];
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
    public function login()
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
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param MailerService $mailerService
     * @param CodeGeneratorService $codeGeneratorService
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler
     * @return JWTAuthenticationSuccessResponse
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        MailerService $mailerService,
        CodeGeneratorService $codeGeneratorService,
        AuthenticationSuccessHandler $authenticationSuccessHandler
    ) {
        $this->validateRequestData($request, UserDTO::class);
        /** @var UserDTO $userDTO */
        $userDTO = $this->data;
        /** @var User $user */
        $user = $userDTO->fromDTO();
        $user->setConfirmationCode($codeGeneratorService->getConfirmationCode($user->getSalt()));
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
        $this->fastSave($user);
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
     * @param User $user
     */
    public function registerConfirm(User $user)
    {
        $user->setActive(true);
        $user->setConfirmationCode('');
        $this->getDoctrine()->getManager()->flush();
        $this->view(['success' => true]);
    }

    /**
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
     *
     * @param Request $request
     * @param RefreshToken $refreshService
     * @return mixed
     */
    public function refresh(Request $request, RefreshToken $refreshService)
    {
        $this->validateRequestData($request, TokenDTO::class);
        return $refreshService->refresh($request);
    }

    public function passwordReset()
    {
    }
}
