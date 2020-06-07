<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Domain\Controller\ControllerHelper;
use App\Domain\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/user") */
class LearnerController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/profile", name="userProfile", methods={"GET"}) */
    public function getProfileAction() : Response
    {
        return $this->response($this->serializer->serialize($this->getUser(), [User::GROUP_DETAILS]));
    }
}