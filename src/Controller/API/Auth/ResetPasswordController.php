<?php

declare(strict_types=1);

namespace App\Controller\API\Auth;

use App\Controller\API\BaseController;
use App\Controller\ControllerHelper;
use App\Model\User\Entity\Types\ConfirmTokenDTO;
use App\Model\User\Entity\UserDTO;
use App\Model\User\UseCase\ResetPassword\RequestHandler;
use App\Model\User\UseCase\ResetPassword\ConfirmHandler;
use App\Service\SerializeService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/auth/rest/password") */
class ResetPasswordController extends AbstractController implements ClassResourceInterface
{
    use ControllerHelper;

    /** @Rest\Route(path="/", name="resetPassword", methods={"POST"}) */
    public function reset(Request $request, RequestHandler $handler, SerializeService $serializer): Response
    {
        /** @var UserDTO $userDTO */
        $userDTO = $serializer->serialize($request, UserDTO::class);
        $handler->handle($userDTO);
        return $this->response($this->getSimpleSuccessResponse());
    }

    /** @Rest\Route(path="/confirm", name="resetPasswordConfirm", methods={"POST"}) */
    public function confirm(Request $request, ConfirmHandler $handler): RedirectResponse
    {
        if (!$token = $request->get('confirmToken')) {
            throw new NotFoundHttpException('Confirm token is required');
        }
        $handler->handle(new ConfirmTokenDTO($token));
        return $this->redirectToRoute('index', [
            'vueRouting' => '',
            'resetPassword' => 'confirm'
        ]);
    }
}
