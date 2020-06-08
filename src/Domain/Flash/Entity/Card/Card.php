<?php

declare(strict_types=1);

namespace App\Domain\Flash\Entity\Card;

use App\Domain\Flash\Entity\Card\Types\Repeat;
use App\Domain\Flash\Entity\Card\Types\Record;
use App\Domain\Flash\Entity\Deck\Deck;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 * @ORM\Table(name="flash_cards")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Serializer\Groups({Card::GROUP_LIST, Card::GROUP_DETAILS})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({Card::GROUP_LIST, Card::GROUP_DETAILS})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Serializer\Groups({Card::GROUP_DETAILS})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Serializer\Groups({Card::GROUP_DETAILS})
     */
    private $updatedAt;

    /**
     * @var Deck
     * @ORM\JoinColumn(name="deck_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(targetEntity="App\Domain\Flash\Entity\Deck\Deck", inversedBy="Cards")
     */
    private $deck;

    /**
     * @var Repeat
     * @ORM\Embedded(class="App\Domain\Flash\Entity\Card\Types\Repeat", columnPrefix="repeat_")
     * @Serializer\Groups({Card::GROUP_DETAILS})
     */
    private $repeat;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Domain\Flash\Entity\Card\Types\Record", mappedBy="card", orphanRemoval=true, cascade={"persist"})
     */
    private $records;
    /**
     * @var ArrayCollection
     * @Serializer\SerializedName("frontSide")
     * @Serializer\Type(name="ArrayCollection<App\Domain\Flash\Entity\Card\Types\Record>")
     * @Serializer\Groups({Card::GROUP_FULL})
     */
    private $frontSideRecords;
    /**
     * @var ArrayCollection
     * @Serializer\SerializedName("backSide")
     * @Serializer\Type(name="ArrayCollection<App\Domain\Flash\Entity\Card\Types\Record>")
     * @Serializer\Groups({Card::GROUP_FULL})
     */
    private $backSideRecords;

    /* CONSTANTS */
    public const GROUP_DETAILS = 'CARD_DETAILS';
    public const GROUP_LIST = 'CARDS_LIST';
    public const GROUP_FULL= 'CARDS_FULL';


    private function __construct(Deck $deck, string $name, DateTimeImmutable $createDate)
    {
        $this->deck = $deck;
        $this->name = $name;
        $this->frontSideRecords = new ArrayCollection();
        $this->backSideRecords = new ArrayCollection();
        $this->records = new ArrayCollection();
        $this->createdAt = $createDate;
        $this->updatedAt = $createDate;
    }
    public static function create(Deck $deck, string $name, Record $front, Record $back, Repeat $repeat, DateTimeImmutable $createDate):Card
    {
        $card = new Card($deck, $name, $createDate);
        if (!$front->isFrontSide()) {
            throw new DomainException('Parameter $front in '.Card::class.'#createBaseCard must have front side');
        }
        if (!$back->isBackSide()) {
            throw new DomainException('Parameter $back in '.Card::class.'#createBaseCard must have back side');
        }
        $card->repeat = $repeat;
        $card->addRecord($front);
        $card->addRecord($back);
        return $card;
    }

    public function update(string $name, Record $front, Record $back, DateTimeImmutable $createDate): Card
    {
        $this->name = $name;
        if (!$front->isFrontSide()) {
            throw new DomainException('Parameter $front in '.Card::class.'#createBaseCard must have front side');
        }
        if (!$back->isBackSide()) {
            throw new DomainException('Parameter $back in '.Card::class.'#createBaseCard must have back side');
        }
        $this->removeRecords();
        $this->addRecord($front);
        $this->addRecord($back);
        $this->setUpdatedAt($createDate);
        return $this;
    }

    public function getFrontSide(): array
    {
        return $this->frontSideRecords->toArray();
    }
    public function getBackSide(): array
    {
        return $this->backSideRecords->toArray();
    }
    private function addRecord(Record $record) : self
    {
        if (!$this->records->contains($record)) {
            if ($record->isFrontSide()) {
                $this->frontSideRecords[] = $record;
                $record->setCard($this);
            } else {
                $this->backSideRecords[] = $record;
                $record->setCard($this);
            }
        }

        return $this;
    }
    private function removeRecords() : self
    {
        foreach ($this->frontSideRecords as $record) {
            /** @var Record $record */
            $record->setCard(null);
        }
        foreach ($this->backSideRecords as $record) {
            /** @var Record $record */
            $record->setCard(null);
        }

        $this->backSideRecords->clear();
        $this->frontSideRecords->clear();
        return $this;
    }

    /** @ORM\PostLoad() */
    public function uploadRecords()
    {
        if ($this->records->count() === 0) {
            $this->records = null;
        } else {
            $this->frontSideRecords = new ArrayCollection();
            $this->backSideRecords = new ArrayCollection();

            foreach ($this->records as $record) {
                /** @var $record Record */
                if ($record->isFrontSide()) {
                    $this->frontSideRecords->add($record);
                } else {
                    $this->backSideRecords->add($record);
                }
            }
        }
    }
    /** @ORM\PrePersist() */
    public function saveRecords()
    {
        $this->records = new ArrayCollection(array_merge($this->getFrontSide(), $this->getBackSide()));
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeck() : Deck
    {
        return $this->deck;
    }
    public function setDeck(Deck $deck)
    {
        $this->deck = $deck;
    }
    public function getId() : int
    {
        return $this->id;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getRepeat(): Repeat
    {
        return $this->repeat;
    }
}
