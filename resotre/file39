<?php

declare(strict_types=1);

namespace App\Domain\Flash\Entity\Card\Types;

use App\Domain\Flash\Entity\Card\Card;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="flash_records")
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({Record::GROUP_DETAILS})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({Record::GROUP_DETAILS})
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $side;

    /**
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(targetEntity="App\Domain\Flash\Entity\Card\Card", inversedBy="records")
     */
    private $card;

    /* CONSTANTS */
    public const GROUP_DETAILS = 'RECORD_DETAILS';


    public const FRONTSIDE = true;
    public const BACKSIDE = false;

    private function __construct(bool $side, string $content)
    {
        Assert::notEmpty($content);
        $this->side = $side;
        $this->content = $content;
    }

    public static function createFrontSide(string $content)
    {
        return new self(Record::FRONTSIDE, $content);
    }
    public static function createBackSide(string $content)
    {
        return new self(Record::BACKSIDE, $content);
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getContent() : string
    {
        return $this->content;
    }

    public function isFrontSide(): bool
    {
        return $this->side === self::FRONTSIDE;
    }
    public function isBackSide(): bool
    {
        return $this->side === self::BACKSIDE;
    }
    public function getSide() : bool
    {
        if ($this->side) {
            return self::FRONTSIDE;
        }
        return self::BACKSIDE;
    }

    public function getCard() : Card
    {
        return $this->card;
    }
    public function setCard(Card $card) : self
    {
        $this->card = $card;
        return $this;
    }
}
