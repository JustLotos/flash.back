<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecordRepository")
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="json") */
    private $Value = [];

    /** @ORM\Column(type="smallint") */
    private $side;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="records")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    private const FRONTSIDE = 'forntside';
    private const BACKSIDE = 'backside';

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getValue() : ?array
    {
        return $this->Value;
    }

    public function setValue(array $Value) : self
    {
        $this->Value = $Value;

        return $this;
    }

    public function getSide() : ?string
    {
        switch ($this->side) {
            case 0:
                return self::FRONTSIDE;
            case 1:
                return self::BACKSIDE;
        }

        return null;
    }

    public function setSide(string $side) : self
    {
        switch ($side) {
            case self::FRONTSIDE:
                $this->side = 0;

                return $this;
            case self::BACKSIDE:
                $this->side = 1;

                return $this;
        }

        return $this;
    }

    public function getCard() : ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card) : self
    {
        $this->card = $card;

        return $this;
    }
}
