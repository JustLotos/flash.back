<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Card\Create;

use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Entity\Card\Types\Record;
use App\Domain\Flash\Entity\Card\Types\Repeat;
use App\Domain\Flash\Entity\Deck\Deck;
use App\Domain\Flash\Repository\CardRepository;
use App\Domain\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;

class Handler
{
    private $flusher;
    private $validator;
    private $repository;

    public function __construct(
        ValidateService $validator,
        FlushService $flusher,
        CardRepository $repository
    ) {
        $this->flusher = $flusher;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function handle(Command $command, Deck $deck): Card
    {
        $this->validator->validate($command);
        $front = Record::createFrontSide($command->frontSide[0]);
        $back  = Record::createBackSide($command->backSide[0]);
        $repeat = new Repeat(new DateTimeImmutable(), $deck->getSettings()->getBaseInterval());
        $card = Card::create($deck, $command->name, $front, $back, $repeat, new DateTimeImmutable());

        $this->repository->add($card);
        $this->flusher->flush();
        return $card;
    }
}
