<?php

declare(strict_types=1);

namespace App\Domain\Flash\Service\AnswerMangerService\Models;

use DateInterval;
use DateTimeImmutable;

interface ISettings
{
    public function getStartTimeInterval() : DateInterval;
    public function getDifficultyIndex() : float;
    public function getMinTimeRepeat() : DateInterval;
}
