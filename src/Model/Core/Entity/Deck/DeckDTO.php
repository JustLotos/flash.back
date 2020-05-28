<?php

declare(strict_types=1);

namespace App\Model\Core\Entity\Deck;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class DeckDTO
{
    /**
     * @Assert\NotBlank(
     *     message="Название колоды не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Assert\Length(
     *     allowEmptyString=false,
     *     min="1",
     *     minMessage="Название колоды не может быть меньше {{ limit }} символа",
     *     max="255",
     *     maxMessage="Название колоды не может быть больше {{ limit }} символов",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="string")
     */
    public $name;

    /**
     * @Assert\Type(
     *     type="string",
     *     message="Описание должно быть строкой",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="string")
    */
    public $description;

    /**
     * @Assert\NotBlank(
     *     message="Ограничение повторения не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Assert\Range(
     *     invalidMessage="Ограничение повторения должно быть числом",
     *     notInRangeMessage="Ограничение повторения должно быть числом от {{ min }} до {{ max }}",
     *     min="1",
     *     minMessage="Ограничение повторения не может быть меньше {{ limit }}",
     *     max="10000",
     *     maxMessage="Огранчение повторения не может быть больше {{ limit }}",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="integer")
     */
    public $limitRepeat;

    /**
     * @Assert\NotBlank(
     *     message="Ограничение изучения не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Assert\Range(
     *     invalidMessage="Ограничение изучения должно быть числом",
     *     notInRangeMessage="Ограничение изучения должно быть числом от {{ min }} до {{ max }}",
     *     min="1",
     *     minMessage="Ограничение изучения не может быть меньше {{ limit }}",
     *     max="10000",
     *     maxMessage="Огранчение изучения не может быть больше {{ limit }}",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="integer")
     */
    public $limitLearning;

    /**
     * @Assert\NotBlank(
     *     message="Коэффициент сложности не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Assert\Range(
     *     invalidMessage="Коэффициент сложности должен быть числом",
     *     notInRangeMessage="Коэффициент сложности должен быть числом от {{ min }} до {{ max }}",
     *     min="1",
     *     minMessage="Коэффициент сложности не может быть меньше {{ limit }}",
     *     max="10000",
     *     maxMessage="Коэффициент сложности не может быть больше {{ limit }}",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="double")
     */
    public $difficultyIndex;

    /**
     * @Assert\NotBlank(
     *     message="Индекс модификатор не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Assert\Range(
     *     invalidMessage="Индекс модификатор должен быть числом",
     *     notInRangeMessage="Индекс модификатор должен быть числом от {{ min }} до {{ max }}",
     *     min="1",
     *     minMessage="Индекс модификатор не может быть меньше {{ limit }}",
     *     max="10000",
     *     maxMessage="Индекс модификатор не может быть больше {{ limit }}",
     *     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
     * )
     * @Serializer\Type(name="double")
     */
    public $modifierIndex;

    /**
     * @Assert\NotBlank(
     *     message="Базовый коэффициент не может быть пустым",
     *     groups={DeckDTO::PUT, DeckDTO::POST},
     * )
     * @Serializer\Type(name="DateInterval")
     */
    public $baseInterval;

    /* CONSTANTS */
    public const PUT = 'PUT';
    public const PATCH = 'PATCH';
    public const POST = 'POST';
//
//* @Assert\Range(
//*     invalidMessage="Базовый коэффициент должен быть числом",
//*     notInRangeMessage="Базовый коэффициент должен быть числом от {{ min }} до {{ max }}",
//*     min="1",
//*     minMessage="Базовый коэффициент не может быть меньше {{ limit }}",
//*     max="10000",
//*     maxMessage="Базовый коэффициент не может быть больше {{ limit }}",
//*     groups={DeckDTO::PUT, DeckDTO::POST, DeckDTO::PATCH},
//* )
}
