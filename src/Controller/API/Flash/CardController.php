<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Controller\ControllerHelper;
use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Entity\Card\Types\Record;
use App\Domain\Flash\Entity\Deck\Deck;
use App\Domain\Flash\Entity\Learner\Types\Id;
use App\Domain\Flash\Repository\CardRepository;
use App\Domain\Flash\UseCase\Card\Create\Command as CreateCommand;
use App\Domain\Flash\UseCase\Card\Create\Handler as CreateHandler;
use App\Domain\Flash\UseCase\Card\Update\Command as UpdateCommand;
use App\Domain\Flash\UseCase\Card\Update\Handler as UpdateHandler;
use App\Security\CardVoter;
use App\Security\DeckVoter;
use App\Service\FlushService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/cards", name="cards_") */
class CardController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/{id<\d+>}", name="get", methods={"GET"}) */
    public function getAction(Request $request, Card $card): Response
    {
        $this->denyAccessUnlessGranted(CardVoter::VIEW, $card, CardVoter::NOT_FOUND_MESSAGE);
        $groups = [Card::GROUP_DETAILS];
        if ($request->query->get('type') && $request->query->get('type') === 'FULL') {
            $groups =  array_merge($groups, [Card::GROUP_FULL, Record::GROUP_DETAILS]);
        }
        return $this->response($this->serializer->serialize($card, $groups));
    }

    /** @Route("/", name="cget", methods={"GET"}) */
    public function cgetAction(Request $request, CardRepository $repository): Response
    {
        $cards = $repository->fetchAll(new Id($this->getUser()->getId()->getValue()));
        $groups = [Card::GROUP_LIST];
        if ($request->query->get('type') && $request->query->get('type') === 'DETAILS') {
            $groups =  array_merge($groups, [Card::GROUP_DETAILS]);
        }
        if ($request->query->get('type') && $request->query->get('type') === 'FULL') {
            $groups =  array_merge($groups, [Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]);
        }
        return $this->response($this->serializer->serialize($cards, $groups));
    }

    /**
     * @Route("/{id<\d+>}", name="create", methods={"POST"})
     */
    public function postAction(Request $request, Deck $deck, CreateHandler $handler) : Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, DeckVoter::NOT_FOUND_MESSAGE);
        /** @var CreateCommand $command */
        $command = $this->serializer->deserialize($request, CreateCommand::class);
        $card = $handler->handle($command, $deck);
        return $this->response($this->serializer->serialize($card, [Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="update", methods={"PUT"}) */
    public function putAction(Request $request, Card $card, UpdateHandler $handler) : Response
    {
        $this->denyAccessUnlessGranted(CardVoter::EDIT, $card, CardVoter::NOT_FOUND_MESSAGE);
        /** @var UpdateCommand $command */
        $command = $this->serializer->deserialize($request, UpdateCommand::class);
        $card = $handler->handle($card, $command);
        return $this->response($this->serializer->serialize($card, [Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="delete", methods={"DELETE"}) */
    public function deleteAction(Card $card, FlushService $flusher, CardRepository $repository) : Response
    {
        $this->denyAccessUnlessGranted(CardVoter::EDIT, $card, CardVoter::NOT_FOUND_MESSAGE);
        $repository->remove($card);
        $flusher->flush();
        return $this->response($this->getSimpleSuccessResponse());
    }
}
