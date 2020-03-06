<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParamsRepeatRepository")
 */
class ParamsRepeat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"repeatParams_details", "repeatParams_list", "repeatParams_deck"})
     */
    private $base;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"repeatParams_details", "repeatParams_list", "repeatParams_deck"})
     */
    private $modifier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deck", mappedBy="paramsRepeat")
     */
    private $decks;

    public function __construct()
    {
        $this->decks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBase(): ?int
    {
        return $this->base;
    }

    public function setBase(int $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getModifier(): ?int
    {
        return $this->modifier;
    }

    public function setModifier(int $modifier): self
    {
        $this->modifier = $modifier;

        return $this;
    }

    /**
     * @return Collection|Deck[]
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    public function addDeck(Deck $deck): self
    {
        if (!$this->decks->contains($deck)) {
            $this->decks[] = $deck;
            $deck->setParamsRepeat($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): self
    {
        if ($this->decks->contains($deck)) {
            $this->decks->removeElement($deck);
            // set the owning side to null (unless already changed)
            if ($deck->getParamsRepeat() === $this) {
                $deck->setParamsRepeat(null);
            }
        }

        return $this;
    }
}
