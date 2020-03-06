<?php

namespace App\Model;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class UserDTO
{
    /**
     * @Serializer\Type(name="string")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="this field is required")
     * @Serializer\Groups(groups={"user_details", "user_list", "user_embed"})
     */
    private $email;

    /**
     * @Assert\Type(
     *      type="string",
     *      message="The values {{ value }} is not valid type {{ type }}"
     * )
     * @Assert\Length(
     *     min="8",
     *     max="255",
     *     minMessage="Password must be at least {{ limit }} characters long",
     *     maxMessage="Password connot be longer than {{ limit }} characters"
     * )
     * @Assert\NotBlank(message="this field is required")
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
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
     *      message="The values {{ value }} is not valid type {{ type }}",
     * )
     * @Assert\Unique(
     *     message="This collection should contain only unique elements {{ value }}"
     * )
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @Serializer\Type("array<string>")
     */
    private $roles = [];

    /**
     * @Assert\Type(
     *    type="string",
     *    message="The values {{ value }} is not valid type {{ type }}"
     * )
     * @Serializer\Groups({"user_details", "user_embed"})
     * @Serializer\Type("string")
     */
    private $firstName;

    /**
     * @Assert\Type(
     *    type="string",
     *    message="The values {{ value }} is not valid type {{ type }}"
     * )
     * @Serializer\Groups({"user_details", "user_embed"})
     * @Serializer\Type("string")
     */
    private $lastName;

    public function getFirstName()
    {
      return $this->firstName;
    }

    public function setFirstName($firstName)
    {
      $this->firstName = $firstName;
      return $this;
    }

    public function getLastName()
    {
      return $this->lastName;
    }

    public function setLastName($lastName)
    {
      $this->lastName = $lastName;
      return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function fromDTO() {
        $user = new User();
        $user->setEmail($this->getEmail());
        $user->setPassword($this->getPassword());
        $user->setRoles($this->getRoles());
        $user->setFirstName($this->getFirstName());
        $user->setLastName($this->getLastName());
        return $user;
    }
}