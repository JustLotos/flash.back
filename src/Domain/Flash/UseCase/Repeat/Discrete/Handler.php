<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Repeat\Discrete;

use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Repository\CardRepository;
use App\Domain\Flash\Service\AnswerMangerService\AnswerManagerService;
use App\Domain\Flash\UseCase\Card\DiscreteRepeat\DiscreteAnswer;
use App\Domain\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateInterval;

class Handler
{
    private $flusher;
    private $validator;
    private $repository;
    private $manger;

    public function __construct(
        ValidateService $validator,
        AnswerManagerService $manger,
        FlushService $flusher,
        CardRepository $repository
    ) {
        $this->flusher = $flusher;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->manger = $manger;
    }

    public function handle(Card $card, Command $command): Card
    {
        $this->validator->validate($command);
        $answer = new DiscreteAnswer(
            $command->date,
            DateInterval::createFromDateString($command->time. " seconds"),
            $command->status
        );

        $interval = $this->manger->getRepeatInterval($card->getRepeat(), $card->getDeck()->getSettings(), $answer);

        $card->getRepeat()->update($answer, $interval);
        $this->flusher->flush();
        return $card;
    }
}
