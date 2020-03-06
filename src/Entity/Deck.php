<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeckRepository")
 */
class Deck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="namse should not be blank")
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"deck_details", "deck_list", "user_embed"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"deck_details", "deck_list", "user_embed"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $limitRepeat;

    /**
     * @ORM\Column(type="integer")
     */
    private $limitLearning;

    /**
     * @ORM\Column(type="integer")
     */
    private $extraLearning;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="deck", orphanRemoval=true)
     * @Serializer\Groups({"deck_details"})
     * @Serializer\MaxDepth(depth=3)
     */
    private $cards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="decks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ParamsRepeat", inversedBy="decks")
     * @ORM\JoinColumn(nullable=true)
     * @Serializer\Groups({"deck_details", "deck_list"})
     */
    private $paramsRepeat;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->setLimitRepeat(1);
        $this->setLimitLearning(1);
        $this->setExtraLearning(1);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLimitRepeat(): ?int
    {
        return $this->limitRepeat;
    }

    public function setLimitRepeat(?int $limitRepeat): self
    {
        $this->limitRepeat = $limitRepeat;

        return $this;
    }

    public function getLimitLearning(): ?int
    {
        return $this->limitLearning;
    }

    public function setLimitLearning(int $limitLearning): self
    {
        $this->limitLearning = $limitLearning;

        return $this;
    }

    public function getExtraLearning(): ?int
    {
        return $this->extraLearning;
    }

    public function setExtraLearning(int $extraLearning): self
    {
        $this->extraLearning = $extraLearning;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setDeck($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getDeck() === $this) {
                $card->setDeck(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getParamsRepeat(): ?paramsRepeat
    {
        return $this->paramsRepeat;
    }

    public function setParamsRepeat(?paramsRepeat $paramsRepeat): self
    {
        $this->paramsRepeat = $paramsRepeat;

        return $this;
    }
}
