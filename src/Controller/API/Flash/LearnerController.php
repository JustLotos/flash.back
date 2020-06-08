<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Controller\ControllerHelper;
use App\Domain\Flash\Entity\Learner\Learner;
use App\Domain\Flash\Entity\Learner\Types\Id;
use App\Domain\Flash\Repository\LearnerRepository;
use App\Domain\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/learner") */
class LearnerController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/profile", name="userProfile", methods={"GET"}) */
    public function getProfileAction(LearnerRepository $repository) : Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Learner $learner */
        $learner = $repository->getById(new Id($user->getId()->getValue()));
        return $this->response($this->serializer->serialize($learner, [Learner::GROUP_SIMPLE]));
    }
}