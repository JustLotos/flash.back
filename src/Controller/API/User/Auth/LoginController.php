<?php

declare(strict_types=1);

namespace App\Controller\API\User\Auth;

use DomainException;
use App\Controller\API\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/auth/login") */
class LoginController extends AbstractController
{
    /** @Route("", name="login", methods={"POST"}) */
    public function login() : void
    {
        throw new DomainException('You shouldn\'t have gotten to this place');
    }
}
