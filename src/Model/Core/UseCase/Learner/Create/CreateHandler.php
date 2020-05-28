<?php

declare(strict_types=1);

namespace App\Model\Core\UseCase\Learner\Create;

use App\Model\Core\Entity\Learner\Learner;
use App\Model\Core\Entity\Learner\Types\Id;
use App\Model\Core\Repository\LearnerRepository;
use App\Model\Flusher;
use App\Model\User\Entity\User;
use App\Service\FlushService;

class CreateHandler
{
    private $repository;
    private $flusher;

    public function __construct(
        LearnerRepository $repository,
        FlushService $flusher
    ) {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(User $user): Learner
    {
        $learner = Learner::create(new Id($user->getId()->getValue()));

        $this->repository->add($learner);
        $this->flusher->flush();

        return $learner;
    }
}
