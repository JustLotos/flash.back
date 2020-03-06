<?php

namespace App\Controller\Rest;

use App\Controller\BaseController;
use App\Entity\User;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Rest\RouteResource(
 *     "User",
 *     pluralize=false
 * )
 * @Rest\Prefix(value="user")
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController implements ClassResourceInterface
{
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        parent::__construct($serializer, $validator);
        $this->serializationGroup = ["user_details", "user_embed"];
    }

    /**
     * @SWG\Get(
     *    operationId="getUserAction",
     *    produces={"application/json"},
     *    summary="Получение текущего пользователя",
     *    description="Получение текущего пользователя",
     *    tags={"UserController"},
     *    @SWG\Parameter(
     *      name="id",
     *      description="Id пользователя",
     *      required=true,
     *      in="path",
     *      type="string"
     *    ),
     *    @SWG\Response(
     *      response="200",
     *      description="Success",
     *      @SWG\Schema(
     *        type="object",
     *        @SWG\Schema(ref=@Model(type=App\Entity\User::class)),
     *        @SWG\Property(property="refresh_token", type="string"),
     *      )
     *    )
     * )
     *
     * @param User $user
     * @return View
     */
    public function getAction(User $user)
    {
        return $this->viewSerialized($user, $this->serializationGroup);
    }
}
