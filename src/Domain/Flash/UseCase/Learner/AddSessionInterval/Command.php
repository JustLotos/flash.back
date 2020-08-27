<?php

declare(strict_types=1);

namespace App\Domain\Flash\UseCase\Learner\AddSessionInterval;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="string")
     */
    public $date;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="int")
     */
    public $duration;
}
