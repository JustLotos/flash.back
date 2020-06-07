<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Register\Request;

use App\Validator\UniqueEntityConstraint\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class Command
{
    /**
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     * @Assert\Email()
     * @UniqueEntity(
     *     message="Пользователь с таким email-адресом уже существует",
     *     class="App\Domain\User\Entity\User",
     *     attribute="email",
     * )
     * @Serializer\Type(name="string")
     */
    public $email;

    /**
     * @Assert\Length(min="8", max="255" )
     * @Assert\NotBlank()
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
