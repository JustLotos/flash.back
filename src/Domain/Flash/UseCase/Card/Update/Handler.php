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

    public function handle(Card $card, Command $cardDTO): Card
    {
        $this->validator->validate($cardDTO, [CardDTO::UPDATE]);
        $front = Record::createFrontSide($cardDTO->frontSide);
        $back = Record::createBackSide($cardDTO->backSide);
        $card->update($cardDTO->name, $front, $back, new DateTimeImmutable());
        $this->flusher->flush();
        return $card;
    }
}
