<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

namespace App\Controller\API\Deck;

use App\Controller\API\BaseController;
use App\Controller\ControllerHelper;
use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Entity\Deck\DeckDTO;
use App\Model\Core\Entity\Learner\Learner;
use App\Model\Core\Entity\Learner\Types\Id;
use App\Model\Core\Repository\DeckFetcher;
use App\Model\Core\Repository\DeckRepository;
use App\Model\Core\Repository\LearnerRepository;
use App\Model\Core\UseCase\Deck\Create\CreateHandler;
use App\Model\Core\UseCase\Deck\Update\UpdateHandler;
use App\Security\DeckVoter;
use App\Service\FlushService;
use App\Service\SerializeService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/decks", name="decks_") */
class DeckController extends AbstractController implements ClassResourceInterface
{
    use ControllerHelper;
    public const NOT_FOUND_MESSAGE = "Колода не найдена";

    private $serializer;
    public function __construct(SerializeService $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @Route("/{id<\d+>}", name="get", methods={"GET"}) */
    public function getAction(Request $request, Deck $deck): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::VIEW, $deck, self::NOT_FOUND_MESSAGE);
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
        /** @var DeckDTO $deckDTO */
        $deckDTO = $this->serializer->deserialize($request, DeckDTO::class);
        $deck = $handler->handle($deckDTO, $learner);
        return $this->response($this->serializer->serialize($deck, [Deck::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="update", methods={"PUT"}) */
    public function putAction(Request $request, Deck $deck, UpdateHandler $handler): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, self::NOT_FOUND_MESSAGE);
        /** @var DeckDTO $deckDTO */
        $deckDTO = $this->serializer->deserialize($request, DeckDTO::class);
        $deck = $handler->handle($deckDTO, $deck);
        return $this->response($this->serializer->serialize($deck, [Deck::GROUP_DETAILS]));
    }

    /** @Route("/{id<\d+>}", name="delete", methods={"DELETE"}) */
    public function deleteAction(Deck $deck, FlushService $flusher, DeckRepository $repository): Response
    {
        $this->denyAccessUnlessGranted(DeckVoter::EDIT, $deck, self::NOT_FOUND_MESSAGE);
        $repository->remove($deck);
        $flusher->flush();
        return $this->response($this->getSimpleSuccessResponse());
    }
}
