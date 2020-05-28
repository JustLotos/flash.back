<?php

declare(strict_types=1);

namespace App\Controller\API\Card;

use App\Controller\API\BaseController;
use App\Controller\API\Deck\DeckController;
use App\Controller\ControllerHelper;
use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\CardDTO;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Entity\Learner\Types\Id;
use App\Model\Core\Repository\CardRepository;
use App\Model\Core\UseCase\Card\Create\CreateHandler;
use App\Model\Core\UseCase\Card\Update\UpdateHandler;
use App\Security\CardVoter;
use App\Security\DeckVoter;
use App\Service\FlushService;
use App\Service\SerializeService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/cards", name="cards_") */
class CardController extends AbstractController implements ClassResourceInterface
{
    public const NOT_FOUND_MESSAGE = "Карточка не найдена";
    use ControllerHelper;

    private $serializer;
    public function __construct(SerializeService $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @Route("/{id<\d+>}", name="get", methods={"GET"}) */
    public function getAction(Request $request, Card $card): Response
    {
        $this->denyAccessUnlessGranted(CardVoter::VIEW, $card, self::NOT_FOUND_MESSAGE);
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
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, DeckController::NOT_FOUND_MESSAGE);
        /** @var CardDTO $cardDTO */
        $cardDTO = $this->serializer->deserialize($request, CardDTO::class);
        $card = $handler->handle($cardDTO, $deck);
        return $this->response($this->serializer->serialize($card, [Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="update", methods={"PUT"}) */
    public function putAction(Request $request, Card $card, UpdateHandler $handler) : Response
    {
        $this->denyAccessUnlessGranted(CardVoter::EDIT, $card, self::NOT_FOUND_MESSAGE);
        /** @var CardDTO $cardDTO */
        $cardDTO = $this->serializer->deserialize($request, CardDTO::class);
        $card = $handler->handle($card, $cardDTO);
        return $this->response($this->serializer->serialize($card, [Card::GROUP_DETAILS, Card::GROUP_FULL, Record::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="delete", methods={"DELETE"}) */
    public function deleteAction(Card $card, FlushService $flusher, CardRepository $repository) : Response
    {
        $this->denyAccessUnlessGranted(CardVoter::EDIT, $card, self::NOT_FOUND_MESSAGE);
        $repository->remove($card);
        $flusher->flush();
        return $this->response($this->getSimpleSuccessResponse());
    }
}
