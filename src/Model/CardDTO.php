<?php


namespace App\Model;
use App\Entity\Card;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class CardDTO
{
    /**
     * @Assert\NotBlank(message="this field is required")
     * @Assert\Type(type="string")
     * @Serializer\Type(name="string")
     * @Serializer\Groups({"default_token"})
     */
    private $name;

    public function getName()
    {
      return $this->name;
    }

    public function setName($name): void
    {
      $this->name = $name;
    }

    public function fromDTO(?Card $card)
    {
        if (!$card) {
          $card = new Card();
        }

        return $card
          ->setName($this->getName());
    }
}