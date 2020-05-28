<?php

declare(strict_types=1);

namespace App\Model\Core\UseCase\Deck\Update;

use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Entity\Deck\DeckDTO;
use App\Model\Core\Entity\Deck\Types\Settings;
use App\Model\Flusher;
use App\Service\FlushService;
use App\Service\ValidateService;
use DateTimeImmutable;

class UpdateHandler
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

    public function handle(DeckDTO $deckDTO, Deck $deck)
    {
        $this->validator->validate($deckDTO, [DeckDTO::PUT]);

        $settings = new Settings(
            $deckDTO->baseInterval,
            $deckDTO->limitRepeat,
            $deckDTO->limitLearning,
            $deckDTO->difficultyIndex,
            $deckDTO->modifierIndex
        );

        $deck->updateFull($deckDTO->name, $settings, $deckDTO->description);
        $deck->setUpdatedAt(new DateTimeImmutable());
        $this->flusher->flush();
        return $deck;
    }
}
