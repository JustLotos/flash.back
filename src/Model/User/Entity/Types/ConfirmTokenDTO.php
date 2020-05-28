<?php

declare(strict_types=1);

namespace App\Model\User\Entity\Types;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmTokenDTO
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="string")
     */
    private $refresh_token;

    public function __construct($token)
    {
        $this->refresh_token = $token;
    }

    public function getToken() : string
    {
        return $this->refresh_token;
    }
}
