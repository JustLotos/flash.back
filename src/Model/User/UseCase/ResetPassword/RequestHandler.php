<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword;

use App\Model\User\Entity\User;
use App\Model\User\Entity\UserDTO;
use App\Model\User\Events\UserCreatedEvent;
use App\Model\User\UserRepository;
use App\Model\User\Service\TokenService;
use App\Service\FlushService;
use App\Service\MailSenderService;
use App\Service\ValidateService;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RequestHandler
{
    private $flusher;
    private $repository;
    private $tokenizer;
    private $sender;
    private $validator;
    private $dispatcher;

    public function __construct(
        ValidateService $validator,
        FlushService $flusher,
        UserRepository $repository,
        TokenService $tokenizer,
        MailSenderService $sender,
        EventDispatcher $dispatcher
    ) {
        $this->flusher = $flusher;
        $this->repository = $repository;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
    }

    public function handle(UserDTO $userDTO): void
    {
        $this->validator->validate($userDTO, [UserDTO::PASSWORD_RESET]);
        /** @var User $user */
        $user = $this->repository->getByEmail($userDTO->getEmail());
        $user->requestResetPassword(
            $this->tokenizer->generate(),
            new DateTimeImmutable(),
            $userDTO->getPassword()
        );
        $event = new UserCreatedEvent($user);
        $this->dispatcher->dispatch($event, UserCreatedEvent::NAME);
        $this->flusher->flush();
        $this->sender->resetPasswordConfirm($user->getEmail(), $user->getConfirmToken()->getToken());
    }
}
