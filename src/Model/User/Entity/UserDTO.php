<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Validator\ExistEntityConstraint\ExistEntity;
use App\Validator\UniqueEntityConstraint\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class UserDTO
{
    /**
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Emai адрес не может быть болшье {{ limit }} символов",
     *     groups={UserDTO::DEFAULT},
     * )
     * @Assert\NotBlank(
     *      message="Поле email обязательно для заполненния",
     *      groups={UserDTO::DEFAULT, UserDTO::REGISTER_CONFIRM},
     * )
     * @Assert\Email(
     *     message = "Поле email '{{ value }}' не является действительным email адресом",
     *     groups={UserDTO::DEFAULT},
     * )
     * @UniqueEntity(
     *     message="Пользователь с таким email-адресом уже существует",
     *     class="App\Model\User\Entity\User",
     *     attribute="email",
     *     groups={UserDTO::DEFAULT},
     * )
     * @ExistEntity(
     *     message="Пользователь с таким email-адресом не существует",
     *     class="App\Model\User\Entity\User",
     *     attribute="email",
     *     groups={UserDTO::REGISTER_CONFIRM, UserDTO::PASSWORD_RESET, UserDTO::PASSWORD_RESET_CONFIRM}
     * )
     * @Serializer\Type(name="string")
     */
    private $email;

    /**
     * @Assert\Type(
     *      type="string",
     *      message="Пароль {{ value }} не является типом {{ type }}",
     *      groups={UserDTO::DEFAULT, UserDTO::PASSWORD_RESET_CONFIRM, UserDTO::PASSWORD_RESET}
     * )
     * @Assert\Length(
     *      min="8",
     *      max="255",
     *      minMessage="Пароль должег содержать как минимум {{ limit }} симвоолов",
     *      maxMessage="Пароль не может быть болшье {{ limit }} символов",
     *      groups={UserDTO::DEFAULT, UserDTO::PASSWORD_RESET_CONFIRM, UserDTO::PASSWORD_RESET}
     * )
     * @Assert\NotBlank(
     *      message="Это поле обязательно для заполнения",
     *      groups={UserDTO::DEFAULT, UserDTO::PASSWORD_RESET}
     * )
     * @Serializer\Type(name="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(
     *      message="Это поле обязательно для заполнения",
     *      groups={UserDTO::DEFAULT, UserDTO::PASSWORD_RESET_CONFIRM}
     * )
     * @Assert\IdenticalTo(
     *      propertyPath="password",
     *      message="Пароли не совпадают",
     *      groups={UserDTO::DEFAULT, UserDTO::PASSWORD_RESET_CONFIRM}
     * )
     * @Serializer\Type(name="string")
     */
    private $plainPassword;

    /**
     * @Serializer\Type(name="string")
     */
    private $roles;

    /* CONSTANTS */
    public const DEFAULT = 'default';
    public const PASSWORD_RESET = 'register_confirm';

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
}
