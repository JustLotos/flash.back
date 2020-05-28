<?php

declare(strict_types=1);

namespace App\Model\Core\Service;

use DateInterval;
use DateTimeImmutable;

class DateIntervalConverter
{
    /**
     * @param DateInterval $dateInterval
     * @return int
     */
    public function toSeconds(DateInterval $dateInterval): int
    {
        $startTime = new DateTimeImmutable();
        $endTime = $startTime->add($dateInterval);
        return $endTime->getTimestamp() - $startTime->getTimestamp();
    }
}
