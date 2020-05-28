<?php

declare(strict_types=1);

namespace App\Controller\API\Card;

use App\Controller\API\BaseController;
use App\Controller\ControllerHelper;
use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\UseCase\Card\DiscreteRepeat\Command;
use App\Model\Core\UseCase\Card\DiscreteRepeat\Handler;
use App\Security\CardVoter;
use App\Service\SerializeService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/cards/{id<\d+>}/repeat", name="cards_repeat_") */
class RepeatController extends AbstractController implements ClassResourceInterface
{
    public const NOT_FOUND_MESSAGE = "Карточка не найдена";
    use ControllerHelper;

    private $serializer;
    public function __construct(SerializeService $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @Route("/discrete", name="discreteRepeat", methods={"POST"}) */
    public function getAction(Request $request, Card $card, Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(CardVoter::VIEW, $card, self::NOT_FOUND_MESSAGE);
        $answerDTO = $this->serializer->deserialize($request, Command::class);
        $handler->handle($card, $answerDTO);
        return $this->response($this->serializer->serialize($card, [
            Card::GROUP_DETAILS,
            Card::GROUP_FULL,
            Record::GROUP_DETAILS
        ]));
    }
}
