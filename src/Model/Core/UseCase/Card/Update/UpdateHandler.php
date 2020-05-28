<?php

declare(strict_types=1);

namespace App\Model\Core\UseCase\Card\Update;

use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\CardDTO;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\Repository\CardRepository;
use App\Model\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;

class UpdateHandler
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

    public function handle(Card $card, CardDTO $cardDTO): Card
    {
        $this->validator->validate($cardDTO, [CardDTO::UPDATE]);
        $front = Record::createFrontSide($cardDTO->frontSide);
        $back = Record::createBackSide($cardDTO->backSide);
        $card->update($cardDTO->name, $front, $back, new DateTimeImmutable());
        $this->flusher->flush();
        return $card;
    }
}
