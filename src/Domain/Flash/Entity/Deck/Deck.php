<?php

declare(strict_types=1);

namespace App\Domain\Flash\Entity\Deck;

use App\Domain\Flash\Entity\Deck\Types\Settings;
use App\Domain\Flash\Entity\Learner\Learner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use DateTimeImmutable;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_decks")
 */
class Deck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({Deck::GROUP_LIST, Deck::GROUP_DETAILS})
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({Deck::GROUP_LIST, Deck::GROUP_DETAILS})
     */
    private $name;
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({Deck::GROUP_LIST, Deck::GROUP_DETAILS})
     */
    private $description;
    /**
     * @ORM\Column(type="datetime_immutable")
     * @Serializer\Groups({Deck::GROUP_DETAILS})
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime_immutable")
     * @Serializer\Groups({Deck::GROUP_DETAILS})
     */
    private $updatedAt;
    /**
     * @var Settings
     * @ORM\Embedded(class="App\Domain\Flash\Entity\Deck\Types\Settings", columnPrefix="settings_")
     * @Serializer\Groups({Deck::GROUP_DETAILS})
     */
    private $settings;
    /**
     * @var Learner
     * @ORM\ManyToOne(targetEntity="App\Domain\Flash\Entity\Learner\Learner", inversedBy="decks")
     * @ORM\JoinColumn(name="learner_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $learner;
    /**
     * @var ArrayCollection|null
     * @ORM\OneToMany(targetEntity="App\Domain\Flash\Entity\Card\Card", mappedBy="deck", orphanRemoval=true, cascade={"persist"})
     * @Serializer\Groups({Deck::GROUP_FULL})
     * @Serializer\SkipWhenEmpty()
     * @Serializer\MaxDepth(depth=1)
     */
    private $cards;

    public const GROUP_LIST = 'DECK_LIST';
    public const GROUP_DETAILS = 'DECK_DETAILS';
    public const GROUP_FULL= 'DECK_FULL';

    public function __construct(
        Learner $learner,
        string $name,
        Settings $settings,
        DateTimeImmutable $date,
        string $description = ''
    ) {
        $this->learner = $learner;
        $this->name = $name;
        $this->settings = $settings;
        $this->description = $description;
        $this->cards = new ArrayCollection();
        $this->createdAt = $date;
        $this->setUpdatedAt($date);
    }

    public function updateSignature(string $name, string $description = '')
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function changeSettings(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function updateFull(string $name, Settings $settings, string $description = '')
    {
        $this->updateSignature($name, $description);
        $this->changeSettings($settings);
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getLearner() : Learner
    {
        return $this->learner;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getSettings(): Settings
    {
        return $this->settings;
    }

    public function getCards(): array
    {
        return $this->cards->toArray();
    }
}
