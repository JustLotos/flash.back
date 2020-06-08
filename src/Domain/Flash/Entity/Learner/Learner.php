<?php

declare(strict_types=1);

namespace App\Domain\Flash\Entity\Learner;

use App\Domain\Flash\Entity\Learner\Types\Id;
use App\Domain\Flash\Entity\Learner\Types\Name;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="flash_learners")
 */
class Learner
{
    /**
     * @var Id
     * @ORM\Column(type="flash_learner_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Name
     * @ORM\Embedded(class="App\Domain\Flash\Entity\Learner\Types\Name")
     * @Serializer\Type(name="App\Domain\Flash\Entity\Learner\Types\Name")
     * @Serializer\Groups({Learner::GROUP_SIMPLE})
     */
    private $name;

    /**
     * @var
     */
    private $avatar;
    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Flash\Entity\Deck\Deck", mappedBy="learner", orphanRemoval=true, cascade={"persist"})
     */
    private $decks;

    public const GROUP_SIMPLE = 'GROUP_SIMPLE';

    private function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public static function create(Id $id): self
    {
        return new self($id);
    }

    public function changeName(Name $name): self
    {
        $this->name = $name;
        return $this;
    }
}
