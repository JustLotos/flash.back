<?php

declare(strict_types=1);

namespace App\Controller\API\User\Auth;

use App\Controller\API\BaseController;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/auth/token") */
class TokenController extends AbstractController
{
    /** @Route("/refresh/", name="refreshToken", methods={"POST"}) */
    public function refresh(Request $request, RefreshToken $refreshService)
    {
        return $refreshService->refresh($request);
    }
}
