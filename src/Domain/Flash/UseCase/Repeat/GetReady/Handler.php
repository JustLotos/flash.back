<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Repeat\GetReady;

use App\Domain\Flash\Repository\CardRepository;
use App\Domain\Flusher;

class Handler
{
    private $repository;

    public function __construct(CardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(): array
    {
        return [];
    }
}
