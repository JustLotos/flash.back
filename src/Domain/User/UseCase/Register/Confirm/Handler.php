<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register\Confirm;

use App\Domain\User\UserRepository;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;
use DomainException;

class Handler
{
    private $repository;
    private $flusher;
    private $validator;

    public function __construct(UserRepository $repository, FlushService $flusher, ValidateService $validator)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->validator = $validator;
    }

    public function handle(Command $token): void
    {
        $this->validator->validate($token);
        if (!$user = $this->repository->findByConfirmToken($token->value)) {
            throw new DomainException('Incorrect or confirmed token.');
        }
        $user->confirmRegister(new DateTimeImmutable());
        $this->flusher->flush();
    }
}
