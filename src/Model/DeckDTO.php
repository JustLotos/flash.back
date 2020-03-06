<?php

namespace App\Model;

use App\Entity\Deck;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class DeckDTO
{
  /**
   * @Assert\NotBlank(message="Название колоды не может быть пустым");
   * @Serializer\Groups({"default"})
   * @Serializer\Type("string")
   */
  private $name;

  /**
   * @Serializer\Groups({"default"})
   * @Serializer\Type("string")
   */
  private $description;

  public function getName()
  {
    return $this->name;
  }

  public function setName($name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description): self
  {
    $this->description = $description;

    return $this;
  }

  public function fromDTO(Deck $deck = null): Deck {
    if (!$deck) {
      $deck = new Deck();
    }

    return $deck
      ->setName($this->getName())
      ->setDescription($this->getDescription());
  }
}