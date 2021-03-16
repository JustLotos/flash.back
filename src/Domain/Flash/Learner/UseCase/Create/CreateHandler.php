<?php

declare(strict_types=1);

namespace App\Domain\Flash\Learner\UseCase\Create;

use App\Domain\Flash\Learner\Entity\Learner;
use App\Domain\Flash\Learner\Entity\Types\Id;
use App\Domain\Flash\Learner\LearnerRepository as Repository;
use App\Domain\User\Entity\User;
use App\Service\FlushService as Flusher;

class CreateHandler
{
    private $repository;
    private $flusher;

    public function __construct(Repository $repository, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(User $user): Learner
    {
        $newLearnerId = new Id($user->getId()->getValue());
        $learner = new Learner($newLearnerId);

        $this->repository->add($learner);
        $this->flusher->flush();

        return $learner;
    }
}
