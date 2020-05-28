<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\ResetPassword;

use App\Model\User\Entity\Types\ConfirmTokenDTO;
use App\Model\User\Entity\User;
use App\Model\User\UserRepository;
use App\Model\User\Service\PasswordEncoder;
use App\Service\FlushService;
use App\Service\ValidateService;
use DomainException;

class ConfirmHandler
{
    /** @var UserRepository */
    private $repository;
    /** @var Flusher */
    private $flusher;
    /** @var ValidateService */
    private $validator;

    public function __construct(
        UserRepository $repository,
        ValidateService $validator,
        FlushService $flusher
    ) {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->validator = $validator;
    }

    public function handle(ConfirmTokenDTO $token): void
    {
        $this->validator->validate($token);

        /** @var User $user */
        if (!$user = $this->repository->findByConfirmToken($token->getToken())) {
            throw new DomainException('Incorrect or confirmed token.');
        }

        //$user->confirmResetPassword(new DateTimeImmutable());
        //$this->flusher->flush();
    }
}
