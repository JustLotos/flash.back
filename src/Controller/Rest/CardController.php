<?php

namespace App\Controller\Rest;

use App\Controller\BaseController;
use App\Entity\Card;
use App\Model\CardDTO;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @param Card $card
     * @return mixed
     */
    public function getAction(Card $card)
    {
        return $this->viewSerialized(
          $card,
          array_merge($this->serializationGroup, ['card_details']));
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @return mixed
     */
    public function cgetAction() {
      $cards = $this
        ->getDoctrine()
        ->getRepository(Card::class)
        ->findAll();

      return $this->viewSerialized($cards, $this->serializationGroup);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request) {
      /** @var CardDTO $cardDTO */
      $cardDTO = $this->validateRequestData($request, CardDTO::class);
      $card = $cardDTO->fromDTO(new Card());
      $this->fastSave($card);
      return $this->view(["status"=> "ok"], Response::HTTP_CREATED);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @param Request $request
     * @param Card $card
     * @return View
     */
    public function putAction(Request $request, Card $card) {
      /** @var CardDTO $cardDTO */
      $cardDTO = $this->validateRequestData($request, CardDTO::class);
      $card = $cardDTO->fromDTO($card);
      $this->getDoctrine()->getManager()->flush();
      return $this->view(["status"=> "success"]);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @param Request $request
     * @param Card $card
     * @return View
     */
    public function patchAction(Request $request, Card $card) {
      /** @var CardDTO $cardDTO */
      $cardDTO = $this->validateRequestData($request, CardDTO::class);
      $card = $cardDTO->fromDTO($card);
      $this->getDoctrine()->getManager()->flush();
      return $this->view(["status"=> "success"]);
    }

    /**
     * @SWG\Response(
     *      response="200",
     *      description="Success",
     * )
     * @SWG\Tag(name="CardController")
     * @param Card $card
     * @return View
     */
    public function deleteAction(Card $card) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($card);
      $em->flush();
      return $this->view(['success'=>true]);
    }
}
