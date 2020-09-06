<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Reset\ByEmail\Request;

use App\Validator\ExistEntityConstraint\ExistEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class Command
{
    /**
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ExistEntity(
     *     class="App\Domain\User\Entity\User",
     *     attribute="email",
     *     message="Пользователя с таким адресом не существует"
     * )
     * @Serializer\Type(name="string")
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="8", max="255" )
     * @Serializer\Type(name="string")
     */
    public $password;

    /**
     * @Assert\NotBlank()
     * @Assert\IdenticalTo(propertyPath="password")
     * @Serializer\Type(name="string")
     */
    public $plainPassword;
}