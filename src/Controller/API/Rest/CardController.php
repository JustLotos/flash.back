<?php

declare(strict_types=1);

namespace App\Controller\API\Rest;

use App\Controller\API\BaseController;
use App\Entity\Card;
use App\Entity\Deck;
use App\Model\CardDTO;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function array_merge;
use function assert;

/**
 * @Rest\Prefix(value="api/v1")
 */
class CardController extends BaseController implements ClassResourceInterface
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        parent::__construct($serializer, $validator);
        $this->serializationGroup = ['card_list'];
    }

    /**
     * @return mixed
     *
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     */
    public function getAction(Card $card)
    {
        $this->denyAccessUnlessGranted('view', $card);

        return $this->viewSerialized(
            $card,
            array_merge($this->serializationGroup, ['card_details'])
        );
    }

    /**
     * @return mixed
     *
     * @Rest\QueryParam()
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     */
    public function cgetAction()
    {
        $cards = $this
            ->getDoctrine()
            ->getRepository(Card::class)
            ->findBy(['user' => $this->getUser()]);

        return $this->viewSerialized($cards, $this->serializationGroup);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @Rest\Post(path="deck/{deck}/cards/")
     * @ParamConverter(name="deck", class="App\Entity\Deck")
     * @SWG\Tag(name="CardController")
     */
    public function postAction(Request $request, Deck $deck) : View
    {
        $this->denyAccessUnlessGranted('edit', $deck);

        $cardDTO = $this->validateRequestData($request, CardDTO::class);
        assert($cardDTO instanceof CardDTO);
        $card = $cardDTO->fromDTO();
        $card->setDeck($deck);
        $this->persist($card);

        return $this->view(['status' => 'ok'], Response::HTTP_CREATED);
    }

    /**
     * @param Deck $deck
     *
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @ParamConverter(name="deck", class="App\Entity\Deck")
     */
    public function putAction(Request $request, Card $card) : View
    {
        $this->denyAccessUnlessGranted('edit', $card->getDeck());
        $cardDTO = $this->validateRequestData($request, CardDTO::class);
        assert($cardDTO instanceof CardDTO);
        $card = $cardDTO->fromDTO($card);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(['status' => 'success']);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     */
    public function patchAction(Request $request, Card $card) : View
    {
        $this->denyAccessUnlessGranted('edit', $card->getDeck());
        $cardDTO = $this->validateRequestData($request, CardDTO::class);
        assert($cardDTO instanceof CardDTO);
        $card = $cardDTO->fromDTO($card);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(['status' => 'success']);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     */
    public function deleteAction(Card $card) : View
    {
        $this->denyAccessUnlessGranted('edit', $card->getDeck());
        $em = $this->getDoctrine()->getManager();
        $em->remove($card);
        $em->flush();

        return $this->view(['success' => true]);
    }
}
