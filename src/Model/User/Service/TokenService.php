<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\Types\ConfirmToken;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class TokenService
{
    public function generate($interval = false): ConfirmToken
    {
        if (!($interval instanceof DateTimeImmutable)) {
            $interval = new DateInterval('PT1H');
        }
        return new ConfirmToken(
            Uuid::uuid4()->toString(),
            (new DateTimeImmutable())->add($interval)
        );
    }
}
