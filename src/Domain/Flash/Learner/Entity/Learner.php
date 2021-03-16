<?php

declare(strict_types=1);

namespace App\Domain\Flash\Learner\Entity;

use App\Domain\FLash\Learner\Entity\Types\Id;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class Learner
{
    /**
     * @var Id
     * @ORM\Column(type="flash_learner_id")
     * @ORM\Id
     * @Serializer\Type(name="string")
     */
    private $id;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
