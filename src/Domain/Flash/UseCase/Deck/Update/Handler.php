<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Deck\Update;

use App\Domain\Flash\Entity\Deck\Deck;
use App\Domain\Flash\Entity\Deck\DeckDTO;
use App\Domain\Flash\Entity\Deck\Types\Settings;
use App\Domain\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;

class Handler
{
    private $flusher;
    private $validator;

    public function __construct(
        ValidateService $validator,
        FlushService $flusher
    ) {
        $this->flusher = $flusher;
        $this->validator = $validator;
    }

    public function handle(Command $deckDTO, Deck $deck)
    {
        $this->validator->validate($deckDTO, [DeckDTO::PUT]);

        $settings = new Settings(
            $deckDTO->baseInterval,
            $deckDTO->limitRepeat,
            $deckDTO->limitLearning,
            $deckDTO->difficultyIndex,
        );

        $deck->updateFull($deckDTO->name, $settings, $deckDTO->description);
        $deck->setUpdatedAt(new DateTimeImmutable());
        $this->flusher->flush();
        return $deck;
    }
}
