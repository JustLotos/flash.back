<?php

declare(strict_types=1);

namespace App\Model\Core\Entity\Card\Types;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class RecordDTO
{
    /**
     * @Assert\NotBlank(groups={RecordDTO::CREATE, RecordDTO::UPDATE})
     * @Serializer\Type(name="string")
     */
    public $id;

    /**
     * @Assert\NotBlank(groups={RecordDTO::CREATE, RecordDTO::UPDATE})
     * @Serializer\Type(name="string")
     */
    public $content;

    public const CREATE = 'CREATE';
    public const UPDATE = 'UPDATE';
}
