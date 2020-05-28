<?php

declare(strict_types=1);

namespace App\Model\Core\Service\AnswerMangerService\Models;

use DateInterval;
use DateTimeImmutable;

interface IRepeat
{
    public function isNew(): bool;
    public function isStudied(): bool;
    public function isRepeatable(): bool;
    public function getRepeatInterval(): DateInterval;
    public function getTotalTime(): DateInterval;
    public function getCount(): int;
    public function getSuccessCount(): int;
}
