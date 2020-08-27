<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register\Request;

use App\Domain\Flusher;
use App\Domain\User\Entity\Types\ConfirmToken;
use App\Domain\User\Entity\Types\Email;
use App\Domain\User\Entity\Types\Id;
use App\Domain\User\Entity\Types\Password;
use App\Domain\User\Entity\Types\Role;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserDTO;
use App\Domain\User\Events\UserCreatedEvent;
use App\Domain\User\Service\TokenService;
use App\Domain\User\UserRepository;
use App\Service\FlushService;
use App\Service\MailSenderService;
use App\Service\ValidateService;
use DateTimeImmutable;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class Handler
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

    public function handle(Command $command): User
    {
        $this->validator->validate($command);

        $user = User::registerByEmail(
            Id::next(),
            new DateTimeImmutable(),
            Role::createUser(),
            new Email($command->email),
            new Password($command->password)
        );

        $event = new UserCreatedEvent($user);
        $this->dispatcher->dispatch($event, UserCreatedEvent::NAME);

        $this->repository->add($user);
        $this->flusher->flush();

        $this->sender->registerConfirm($user->getEmail()->getValue(), $user->getConfirmToken()->getToken());
        return $user;
    }
}
