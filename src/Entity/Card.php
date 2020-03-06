<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"card_list", "card_details", "card_deck"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"card_details", "card_deck"})
     */
    private $dateNextRepeat;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"card_details", "card_deck"})
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"card_details", "card_deck"})
     */
    private $dateLastModified;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"card_details", "card_deck"})
     */
    private $difficultyIndex;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deck", inversedBy="Cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Record", mappedBy="card", orphanRemoval=true)
     * @Serializer\Groups({"card_details", "card_deck"})
     */
    private $records;

    public function __construct()
    {
        $this->records = new ArrayCollection();
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

    public function getDateNextRepeat(): ?\DateTimeInterface
    {
        return $this->dateNextRepeat;
    }

    public function setDateNextRepeat(\DateTimeInterface $dateNextRepeat): self
    {
        $this->dateNextRepeat = $dateNextRepeat;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateLastModified(): ?\DateTimeInterface
    {
        return $this->dateLastModified;
    }

    public function setDateLastModified(\DateTimeInterface $dateLastModified): self
    {
        $this->dateLastModified = $dateLastModified;

        return $this;
    }

    public function getDifficultyIndex(): ?int
    {
        return $this->difficultyIndex;
    }

    public function setDifficultyIndex(int $difficultyIndex): self
    {
        $this->difficultyIndex = $difficultyIndex;

        return $this;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): self
    {
        $this->deck = $deck;

        return $this;
    }

    /**
     * @return Collection|Record[]
     */
    public function getRecords(): Collection
    {
        return $this->records;
    }

    public function addRecord(Record $record): self
    {
        if (!$this->records->contains($record)) {
            $this->records[] = $record;
            $record->setCard($this);
        }

        return $this;
    }

    public function removeRecord(Record $record): self
    {
        if ($this->records->contains($record)) {
            $this->records->removeElement($record);
            // set the owning side to null (unless already changed)
            if ($record->getCard() === $this) {
                $record->setCard(null);
            }
        }

        return $this;
    }
}
