<?php

declare(strict_types=1);

namespace App\Model\Core\Entity\Learner;

use App\Model\Core\Entity\Learner\Types\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="core_learners")
 */
class Learner
{
    /**
     * @var Id
     * @ORM\Column(type="core_learner_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Core\Entity\Deck\Deck", mappedBy="learner", orphanRemoval=true, cascade={"persist"})
     */
    private $decks;

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
}
