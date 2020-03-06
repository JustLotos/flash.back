<?php

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

    /**
     * @ORM\Column(type="json")
     */
    private $Value = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $hint = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $side;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="records")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?array
    {
        return $this->Value;
    }

    public function setValue(array $Value): self
    {
        $this->Value = $Value;

        return $this;
    }

    public function getHint(): ?array
    {
        return $this->hint;
    }

    public function setHint(?array $hint): self
    {
        $this->hint = $hint;

        return $this;
    }

    public function getSide(): ?int
    {
        return $this->side;
    }

    public function setSide(int $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }
}
