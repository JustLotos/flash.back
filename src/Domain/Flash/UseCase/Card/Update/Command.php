<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Card\Update;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255)
     * @Serializer\Type(name="string")
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", max="1")
     * @Serializer\Type(name="ArrayCollection<string>")
     */
    public $frontSide;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", max="1")
     * @Serializer\Type(name="ArrayCollection<string>")
     */
    public $backSide;
}
