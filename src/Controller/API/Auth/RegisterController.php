<?php

declare(strict_types=1);

namespace App\Controller\API\Auth;

use App\Exception\ValidationException;
use App\Model\User\Entity\Types\ConfirmTokenDTO;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserDTO;
use App\Model\User\UseCase\Register\ConfirmHandler;
use App\Model\User\UseCase\Register\RequestHandler;
use App\Service\SerializeService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/auth/register") */
class RegisterController extends AbstractController implements ClassResourceInterface
{
    /** @Route("", name="register", methods={"POST"}) */
    public function register(
        Request $request,
        SerializeService $serializer,
        RequestHandler $handler,
        AuthenticationSuccessHandler $ash
    ): JWTAuthenticationSuccessResponse {
        /** @var UserDTO $userDTO */
        $userDTO = $serializer->deserialize($request, UserDTO::class);
        /** @var User $user */
        $user = $handler->handle($userDTO);
        return $ash->handleAuthenticationSuccess($user);
    }

    /** @Route("/confirm", name="registerConfirm", methods={"GET"}) */
    public function confirm(Request $request, ConfirmHandler $handler): RedirectResponse
    {
        if (!$token = $request->get('confirmToken')) {
            throw new ValidationException(
                json_encode(['confirmToken'=>"this field is required"]),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $handler->handle(new ConfirmTokenDTO($token));

        return $this->redirectToRoute('index', [
            'vueRouting' => '',
            'register' => 'confirm'
        ]);
    }
}
