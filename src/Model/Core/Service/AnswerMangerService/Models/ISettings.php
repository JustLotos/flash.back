<?php

declare(strict_types=1);

namespace App\Model\Core\Service\AnswerMangerService\Models;

use DateInterval;
use DateTimeImmutable;

interface ISettings
{
    public function getBaseInterval() : DateInterval;
    public function getDifficultyIndex() : float;
    public function getMinTimeRepeat() : DateInterval;
}
