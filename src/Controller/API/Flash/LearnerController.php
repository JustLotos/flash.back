<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Controller\ControllerHelper;
use App\Domain\Flash\Learner\Entity\Learner;
use App\Domain\Flash\Learner\Entity\Types\Id;
use App\Domain\Flash\Learner\LearnerRepository;
use App\Domain\Flash\UseCase\Learner\AddSessionInterval\Command as AddSessionCommand;
use App\Domain\Flash\UseCase\Learner\AddSessionInterval\Handler as AddSessionHandler;
use App\Domain\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/learner") */
class LearnerController extends AbstractController
{
    use ControllerHelper;


    /** @Route("/profile", name="userProfile", methods={"GET"}) */
    public function getProfileAction(Request $request, LearnerRepository $repository) : Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Learner $learner */
        $learner = $repository->getById(new Id($user->getId()->getValue()));
        $groups = [Learner::GROUP_SIMPLE];
        if ($request->query->get('type') && $request->query->get('type') === 'DETAILS') {
            $groups =  array_merge($groups, [Learner::GROUP_DETAILS]);
        }
        return $this->response($this->serializer->serialize($learner, $groups));
    }

    /** @Route("/session", name="userProfile", methods={"POST"}) */
    public function sendSession(Request $request, AddSessionHandler $handler, LearnerRepository $repository)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Learner $learner */
        $learner = $repository->getById(new Id($user->getId()->getValue()));
        /** @var AddSessionCommand $command */
        $command = $this->serializer->deserialize($request, AddSessionCommand::class);
        $handler->handle($learner, $command);

        $file = 'people.txt';
// Новый человек, которого нужно добавить в файл
        $person = "John Smith\n";
// Пишем содержимое в файл,
// используя флаг FILE_APPEND для дописывания содержимого в конец файла
// и флаг LOCK_EX для предотвращения записи данного файла кем-нибудь другим в данное время
        file_put_contents($file, $person, FILE_APPEND | LOCK_EX);

        return $this->response($this->getSimpleSuccessResponse());
    }
}