<?php

declare(strict_types=1);

namespace App\Controller\API\User;

use DomainException;
use App\Controller\API\BaseController;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/auth") */
class AuthController extends AbstractController
{
    /** @Route("/login", name="login", methods={"POST"}) */
    public function login() : void
    {
        throw new DomainException('You shouldn\'t have gotten to this place');
    }

    /** @Route("/token/refresh", name="refreshToken", methods={"POST"}) */
    public function refresh(Request $request, RefreshToken $refreshService)
    {
        return $refreshService->refresh($request);
    }
}
