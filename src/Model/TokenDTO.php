<?php


namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class TokenDTO
{
    /**
     * @Assert\NotBlank(message="this field is required")
     * @Assert\Type(type="string")
     * @Assert\Length(min="128", max="128")
     * @Serializer\Type(name="string")
     * @Serializer\Groups({"default_token"})
     */
    private $refresh_token;

    public function getRefreshToken(): string
    {
      return $this->refresh_token;
    }

    public function setRefreshToken(string $refresh_token): self
    {
      $this->refresh_token = $refresh_token;
      return $this;
    }
}