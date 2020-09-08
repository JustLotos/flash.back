<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Change\Role;

use App\Validator\ExistEntityConstraint\ExistEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\User\Entity\Types\Role;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({Role::USER, Role::ADMIN})
     * @Serializer\Type(name="string")
     */
    public $role;

    /**
     * @Assert\NotBlank()
     * @ExistEntity(
     *     attribute="id",
     *     class="App\Domain\User\Entity\User",
     *     message="Пользователь не найден",
     * )
     * @Serializer\Type(name="string")
     */
    public $id;
}
