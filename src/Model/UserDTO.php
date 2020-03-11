<?php

namespace App\Model;

use App\Entity\User;
use App\Validator\UniqueEntityConstraint\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class UserDTO
{
    /**
     * @Serializer\Type(name="string")
     * @Assert\Email(message = "Поле email '{{ value }}' не является действительным email адресом")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Emai адрес не может быть болшье {{ limit }} символов"
     * )
     * @Assert\NotBlank(message="Поле email обязательно для заполненния")
     * @Serializer\Groups(groups={"user_details", "user_list", "user_embed", "login"})
     * @UniqueEntity(
     *     message="Пользователь с таким email адресом уже существует",
     *     class="App\Entity\User",
     *     attribute="email"
     * )
     */
    private $email;

    /**
     * @Assert\Type(
     *      type="string",
     *      message="Пароль {{ value }} не является типом {{ type }}"
     * )
     * @Assert\Length(
     *     min="8",
     *     max="255",
     *     minMessage="Пароль должег содержать как минимум {{ limit }} симвоолов",
     *     maxMessage="Пароль не может быть болшье {{ limit }} символов"
     * )
     * @Assert\NotBlank(message="this field is required")
     * @Serializer\Groups({"user_details", "user_list", "user_embed", "login"})
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * @Assert\NotBlank(message="this field is required")
     * @Assert\IdenticalTo(propertyPath="password")
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @Serializer\Type("string")
     */
    private $plainPassword;

    /**
     * @Assert\Type(
     *      type="array",
     *      message="Список ролей {{ value }} не является допустимым типом {{ type }}",
     * )
     * @Assert\Unique(
     *     message="Список ролей должен содержить только уинкальные значения {{ value }}"
     * )
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @Serializer\Type("array<string>")
     */
    private $roles = [];

    /**
     * @Assert\Type(
     *    type="string",
     *    message="Значение имени пользователья {{ value }} не является допустимым типом {{ type }}"
     * )
     * @Serializer\Groups({"user_details", "user_embed"})
     * @Serializer\Type("string")
     */
    private $firstName;

    /**
     * @Assert\Type(
     *    type="string",
     *    message="Значение фаимилии пользователья {{ value }} не является допустимым типом {{ type }}"
     * )
     * @Serializer\Groups({"user_details", "user_embed"})
     * @Serializer\Type("string")
     */
    private $lastName;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function fromDTO(User $user = null): User
    {
        $user ?: $user = new User();
        $user->setEmail($this->getEmail());
        $user->setPassword($this->getPassword());
        $this->getRoles() ? $user->setRoles($this->getRoles()):$user->setRoles([]);
        return $user;
    }
}
