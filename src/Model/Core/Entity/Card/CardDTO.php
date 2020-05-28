<?php

declare(strict_types=1);

namespace App\Model\Core\Entity\Card;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class CardDTO
{
    /**
     * @Assert\NotBlank(groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Assert\Length(max="255", groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Serializer\Type(name="string")
     */
    public $name;

    /**
     * @Assert\NotBlank(groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Assert\Valid(groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", max="1", groups={CardDTO::UPDATE, CardDTO::UPDATE} )
     * @Serializer\Type(name="ArrayCollection<App\Model\Core\Entity\Card\Types\RecordDTO>")
     */
    public $frontSide;

    /**
     * @Assert\NotBlank(groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Assert\Valid(groups={CardDTO::UPDATE, CardDTO::UPDATE})
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", max="1", groups={CardDTO::UPDATE, CardDTO::UPDATE} )
     * @Serializer\Type(name="ArrayCollection<App\Model\Core\Entity\Card\Types\RecordDTO>")
     */
    public $backSide;


    /* CONSTANTS */
    public const CREATE = 'CREATE';
    public const UPDATE = 'UPDATE';
}
