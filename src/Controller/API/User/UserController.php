<?php

declare(strict_types=1);

namespace App\Controller\API\User;

use App\Controller\API\BaseController;
use App\Controller\ControllerHelper;
use App\Model\User\Entity\User;
use App\Service\SerializeService;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route(value="api/v1/user") */
class UserController extends AbstractController implements ClassResourceInterface
{
    use ControllerHelper;

    private $serializer;
    public function __construct(SerializeService $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @Route("/profile", name="userProfile", methods={"GET"}) */
    public function getProfileAction() : Response
    {
        return $this->response($this->serializer->serialize($this->getUser(), [User::GROUP_DETAILS]));
    }
}
