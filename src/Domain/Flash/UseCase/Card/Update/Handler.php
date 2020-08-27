<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Card\Update;

use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Entity\Card\CardDTO;
use App\Domain\Flash\Entity\Card\Types\Record;
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

    public function handle(Card $card, Command $command): Card
    {
        $this->validator->validate($command);
        $front = Record::createFrontSide($command->frontSide[0]->content);
        $back = Record::createBackSide($command->backSide[0]->content);
        $card->update($command->name, $front, $back, new DateTimeImmutable());

        $this->repository->add($card);
        $this->flusher->flush();

        return $card;
    }
}
