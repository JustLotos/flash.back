<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Card\Update;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Record
{
    /**
     * @Serializer\Type(name="integer")
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="string")
     */
    public $content;
}
