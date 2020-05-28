<?php

declare(strict_types=1);

namespace App\Model\Core\UseCase\Card\Create;

use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\CardDTO;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\Entity\Card\Types\Repeat;
use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Repository\CardRepository;
use App\Model\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;

class CreateHandler
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

    public function handle(CardDTO $cardDTO, Deck $deck): Card
    {
        $this->validator->validate($cardDTO, [CardDTO::CREATE]);
        $front = Record::createFrontSide($cardDTO->frontSide[0]->content);
        $back  = Record::createBackSide($cardDTO->backSide[0]->content);
        $repeat = new Repeat(new DateTimeImmutable(), $deck->getSettings()->getBaseInterval());
        $card = Card::create($deck, $cardDTO->name, $front, $back, $repeat, new DateTimeImmutable());

        $this->repository->add($card);
        $this->flusher->flush();
        return $card;
    }
}
