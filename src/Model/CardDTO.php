<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Card;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class CardDTO
{
    /**
     * @Assert\NotBlank(message="Это поле обязательно для заполнения")
     * @Assert\Type(type="string")
     * @Serializer\Type(name="string")
     * @Serializer\Groups({"card_details", "card_list"})
     */
    private $name;

    // TODO сложная валидация влооженных объектов
    private $records;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name) : void
    {
        $this->name = $name;
    }

    public function fromDTO(?Card $card = null)
    {
        if (! $card) {
            $card = new Card($this->getName());
        } else {
            $card->setName($this->getName());
        }

        return $card;
    }
}
