<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Card\Create;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="string")
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="ArrayCollection<App\Domain\Flash\UseCase\Card\Create\Record>")
     */
    public $frontSide;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="ArrayCollection<App\Domain\Flash\UseCase\Card\Create\Record>")
     */
    public $backSide;
}
