<?php

declare(strict_types=1);

namespace App\Controller\API\Flash;

use App\Controller\ControllerHelper;
use App\Domain\Flash\Entity\Card\Card;
use App\Domain\Flash\Entity\Card\Types\Record;
use App\Domain\Flash\Entity\Deck\Deck;
use App\Domain\Flash\Entity\Learner\Learner;
use App\Domain\Flash\Entity\Learner\Types\Id;
use App\Domain\Flash\Repository\DeckFetcher;
use App\Domain\Flash\Repository\DeckRepository;
use App\Domain\Flash\Repository\LearnerRepository;
use App\Domain\Flash\UseCase\Deck\Create\Command as CreateCommand;
use App\Domain\Flash\UseCase\Deck\Create\Handler as CreateHandler;
use App\Domain\Flash\UseCase\Deck\Update\Command as UpdateCommand;
use App\Domain\Flash\UseCase\Deck\Update\Handler as UpdateHandler;
use App\Security\DeckVoter;
use App\Service\FlushService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/decks", name="decks_") */
class DeckController extends AbstractController
{
    use ControllerHelper;

    /** @Route("/{id<\d+>}", name="get", methods={"GET"}) */
    public function getAction(Request $request, Deck $deck): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::VIEW, $deck, DeckVoter::NOT_FOUND_MESSAGE);
        $groups = [Deck::GROUP_DETAILS, Deck::GROUP_FULL, Card::GROUP_LIST];
        if ($request->query->get('type') && $request->query->get('type') == 'FULL') {
            $groups =  array_merge($groups, [Card::GROUP_FULL, Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]);
        }
        return $this->response($this->serializer->serialize($deck, $groups));
    }

    /** @Route("/", name="cget", methods={"GET"}) */
    public function cgetAction(Request $request, DeckRepository $repository): Response
    {
        $decks = $repository->fetchAll(new Id($this->getUser()->getId()->getValue()));
        $groups = [Deck::GROUP_LIST];
        if ($request->query->get('type') && $request->query->get('type') === 'DETAIL') {
            $groups =  array_merge($groups, [Deck::GROUP_DETAILS]);
        }
        if ($request->query->get('type') && $request->query->get('type') === 'FULL') {
            $groups =  array_merge($groups, [Deck::GROUP_DETAILS, Deck::GROUP_FULL, Card::GROUP_LIST]);
        }
        return $this->response($this->serializer->serialize($decks, $groups));
    }

    /** @Route("/", name="create", methods={"POST"}) */
    public function postAction(Request $request, CreateHandler $handler, LearnerRepository $repository): Response
    {
        /** @var Learner $learner */
        $learner = $repository->getById(new Id($this->getUser()->getId()->getValue()));
        /** @var CreateCommand $command */
        $command = $this->serializer->deserialize($request, CreateCommand::class);
        $deck = $handler->handle($command, $learner);
        return $this->response($this->serializer->serialize($deck, [Deck::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="update", methods={"PUT"}) */
    public function putAction(Request $request, Deck $deck, UpdateHandler $handler): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, DeckVoter::NOT_FOUND_MESSAGE);
        /** @var UpdateCommand $command */
        $command = $this->serializer->deserialize($request, UpdateCommand::class);
        $deck = $handler->handle($command, $deck);
        return $this->response($this->serializer->serialize($deck, [Deck::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="delete", methods={"DELETE"}) */
    public function deleteAction(Deck $deck, FlushService $flusher, DeckRepository $repository): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, DeckVoter::NOT_FOUND_MESSAGE);
        $repository->remove($deck);
        $flusher->flush();
        return $this->response($this->getSimpleSuccessResponse());
    }
}
