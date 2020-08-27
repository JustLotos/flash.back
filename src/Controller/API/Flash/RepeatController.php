<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Controller\ControllerHelper;
use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Entity\Card\Types\Record;
use App\Domain\Flash\UseCase\Repeat\Discrete\Command as DiscreteRepeatCommand;
use App\Domain\Flash\UseCase\Repeat\Discrete\Handler as DiscreteRepeatHandler;
use App\Security\CardVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/cards/{id<\d+>}/repeat", name="cards_repeat_") */
class RepeatController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/discrete", name="discreteRepeat", methods={"POST"}) */
    public function discrete(Request $request, Card $card, DiscreteRepeatHandler $handler): Response
    {
        $this->denyAccessUnlessGranted(CardVoter::VIEW, $card, CardVoter::NOT_FOUND_MESSAGE);
        /** @var DiscreteRepeatCommand $command */
        $command = $this->serializer->deserialize($request, DiscreteRepeatCommand::class);
        $handler->handle($card, $command);
        return $this->response($this->serializer->serialize($card, [
            Card::GROUP_DETAILS,
            Card::GROUP_FULL,
            Record::GROUP_DETAILS
        ]));
    }
}
