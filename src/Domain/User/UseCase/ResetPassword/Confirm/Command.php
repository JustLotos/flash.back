<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\ResetPassword\Confirm;

use App\Validator\ExistEntityConstraint\ExistEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type(name="string")
     */
    public $token;

    public function __construct(string $value)
    {
        $this->token = $value;
    }
}
