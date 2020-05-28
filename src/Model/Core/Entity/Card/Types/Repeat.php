<?php

declare(strict_types=1);

namespace App\Model\Core\Entity\Card\Types;

use App\Model\Core\Service\AnswerMangerService\Models\IAnswer;
use App\Model\Core\Service\AnswerMangerService\Models\IRepeat;
use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/** @ORM\Embeddable */
class Repeat implements IRepeat
{
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_DETAILS})
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_DETAILS})
     */
    private $count;

    /**
     * @var DateInterval
     * @ORM\Column(type="dateinterval")
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_DETAILS})
     */
    private $totalTime;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_DETAILS})
     */
    private $successCount;

    /**
     * @var DateInterval
     * @ORM\Column(type="dateinterval")
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_DETAILS})
     */
    private $interval;

    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     * @Serializer\Groups({App\Model\Core\Entity\Card\Card::GROUP_LIST})
     */
    private $state;

    public const INITIAL_COUNT_REPEAT = 0;

    public const NEW = 'NEW';
    public const STUDIED = 'STUDIED';
    public const REPEATABLE = 'REPEATABLE';

    public function __construct(
        DateTimeImmutable $date,
        DateInterval $interval
    ) {
        $this->state = self::NEW;
        $this->date = $date;
        $this->interval = $interval;
        $this->totalTime = DateInterval::createFromDateString('0 seconds');
        $this->count = self::INITIAL_COUNT_REPEAT;
        $this->successCount = self::INITIAL_COUNT_REPEAT;
    }

    public function update(IAnswer $answer, DateInterval $repeatInterval)
    {
        $this->count = $this->getCount() + 1;
        $this->date = $answer->getDate();
        $this->interval = $repeatInterval;
        !$answer->isSuccess() ?: $this->successCount = $this->getSuccessCount() + 1;
        $this->totalTime = DateInterval::createFromDateString(
            $this->toSeconds($answer->getTime()) + $this->toSeconds($this->totalTime). " seconds"
        );
        $this->changeState();
    }

    private function changeState(): self
    {
        if ($this->state == self::NEW) {
            $this->state = self::STUDIED;
        } elseif ($this->state == self::STUDIED) {
            $this->state = self::REPEATABLE;
        }
        return $this;
    }

    public function next(): DateTimeImmutable
    {
        return $this->getDate()->add($this->getRepeatInterval());
    }

    public function getRepeatInterval(): DateInterval
    {
        return $this->interval;
    }
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
    public function getTotalTime(): DateInterval
    {
        return $this->totalTime;
    }
    public function getCount() : int
    {
        return $this->count;
    }
    public function getSuccessCount() : int
    {
        return $this->successCount;
    }
    public function getState()
    {
        return $this->state;
    }
    public function isNew(): bool
    {
        return $this->state == self::NEW;
    }
    public function isStudied(): bool
    {
        return $this->state == self::STUDIED;
    }
    public function isRepeatable(): bool
    {
        return $this->state == self::REPEATABLE;
    }

    private function toSeconds(DateInterval $dateInterval): int
    {
        $startTime = new DateTimeImmutable();
        $endTime = $startTime->add($dateInterval);
        return $endTime->getTimestamp() - $startTime->getTimestamp();
    }
}
