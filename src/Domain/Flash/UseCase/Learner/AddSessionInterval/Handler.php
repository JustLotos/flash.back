<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Learner\AddSessionInterval;

use App\Domain\Flash\Entity\Learner\Learner;
use App\Domain\Flash\Entity\Learner\Types\Id;
use App\Domain\Flash\Entity\Learner\Types\Session;
use App\Domain\Flash\Repository\LearnerRepository;
use App\Domain\Flusher;
use App\Domain\User\Entity\User;
use App\Service\FlushService;
use App\Service\ValidateService;

class Handler
{
    private $repository;
    private $flusher;
    private $validator;

    public function __construct(
        ValidateService $validator,
        LearnerRepository $repository,
        FlushService $flusher
    ) {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->validator = $validator;
    }

    public function handle(Learner $learner, Command $command)
    {
        $this->validator->validate($command);
        $intervals = round($command->duration / Session::DEFAULT_DURATION);
        $hours = date('H', strtotime($command->date));
        for ($i=0; $i < $intervals; $i++) {
            $result = $hours * 3600 + Session::DEFAULT_DURATION * $i;
            $learner->getSession()->updateIntervalSchedule($result);
        }
        $this->flusher->flush();
    }
}
