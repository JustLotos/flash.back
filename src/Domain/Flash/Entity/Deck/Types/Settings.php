<?php

declare(strict_types=1);

namespace App\Domain\Flash\Entity\Deck\Types;

use App\Domain\Flash\Service\AnswerMangerService\Models\ISettings;
use Doctrine\ORM\Mapping as ORM;
use DateInterval;
use JMS\Serializer\Annotation as Serializer;

/** @ORM\Embeddable */
class Settings implements ISettings
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({App\Domain\Flash\Entity\Deck\Deck::GROUP_DETAILS})
     */
    private $limitRepeat;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({App\Domain\Flash\Entity\Deck\Deck::GROUP_DETAILS})
     */
    private $limitLearning;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Serializer\Groups({App\Domain\Flash\Entity\Deck\Deck::GROUP_DETAILS})
     */
    private $difficultyIndex;

    /**
     * @var DateInterval
     * @ORM\Column(type="dateinterval")
     * @Serializer\Groups({App\Domain\Flash\Entity\Deck\Deck::GROUP_DETAILS})
     */
    private $startTimeInterval;

    /**
     * @var DateInterval
     * @ORM\Column(type="dateinterval")
     * @Serializer\Groups({App\Domain\Flash\Entity\Deck\Deck::GROUP_DETAILS})
     */
    private $minTimeInterval;

    /* CONSTANTS */
    public const DEFAULT_LIMIT_REPEAT = 20;
    public const DEFAULT_LIMIT_LEARNING = 20;
    public const DEFAULT_DIFFICULTY_INDEX = 1;

    public function __construct(
        DateInterval $baseInterval = null,
        DateInterval $minTimeRepeat = null,
        int $limitRepeat = self::DEFAULT_LIMIT_REPEAT,
        int $limitLearning = self::DEFAULT_LIMIT_LEARNING,
        float $difficultyIndex = self::DEFAULT_DIFFICULTY_INDEX
    ) {
        $baseInterval ?
            $this->startTimeInterval = $baseInterval:
            $this->startTimeInterval = DateInterval::createFromDateString('3600 seconds');
        $minTimeRepeat ?
            $this->minTimeInterval = $minTimeRepeat:
            $this->minTimeInterval = DateInterval::createFromDateString('60 seconds');

        $this->limitRepeat = $limitRepeat;
        $this->limitLearning = $limitLearning;
        $this->difficultyIndex = $difficultyIndex;
    }

    public function getMinTimeRepeat(): DateInterval
    {
        return $this->minTimeInterval;
    }

    public function getStartTimeInterval() : DateInterval
    {
        return $this->startTimeInterval;
    }

    public function getLimitRepeat() : int
    {
        return $this->limitRepeat;
    }
    public function getLimitLearning() : int
    {
        return $this->limitLearning;
    }

    public function getDifficultyIndex() : float
    {
        return $this->difficultyIndex;
    }
}
