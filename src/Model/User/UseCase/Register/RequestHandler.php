<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Register;

use App\Model\Flusher;
use App\Model\User\Entity\Types\Id;
use App\Model\User\Entity\Types\Role;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserDTO;
use App\Model\User\Events\UserCreatedEvent;
use App\Model\User\Service\TokenService;
use App\Model\User\UserRepository;
use App\Service\FlushService;
use App\Service\MailSenderService;
use App\Service\ValidateService;
use DateTimeImmutable;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RequestHandler
{
    private $flusher;
    private $validator;
    private $repository;
    private $sender;
    private $tokenizer;
    private $dispatcher;

    public function __construct(
        ValidateService $validator,
        TokenService $tokenizer,
        UserRepository $repository,
        FlushService $flusher,
        MailSenderService $sender,
        EventDispatcherInterface $dispatcher
    ) {
        $this->flusher = $flusher;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->sender = $sender;
        $this->tokenizer = $tokenizer;
        $this->dispatcher = $dispatcher;
    }

    public function handle(UserDTO $userDTO)
    {
        $this->validator->validate($userDTO, [UserDTO::DEFAULT]);

        /** @var User $user */
        $user = User::registerByEmail(
            Id::next(),
            new DateTimeImmutable(),
            Role::user(),
            $this->tokenizer->generate(),
            $userDTO->getEmail(),
            $userDTO->getPassword()
        );

        $event = new UserCreatedEvent($user);
        $this->dispatcher->dispatch($event, UserCreatedEvent::NAME);

        $this->repository->add($user);
        $this->flusher->flush();

        $this->sender->registerConfirm($user->getEmail(), $user->getConfirmToken()->getToken());
        return $user;
    }
}
