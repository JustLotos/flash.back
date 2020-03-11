<?php

namespace App\Controller;


use App\Exception\ValidationException;
use Doctrine\Common\Inflector\Inflector;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractFOSRestController
{
    private $serializer;
    private $validator;
    protected $response;
    protected $serializationGroup;
    protected $data;

    private const RESPONSE_FORMAT = 'json';

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->response = new JsonResponse();
    }

    protected function validateRequestData(Request $request, string $model)
    {
        $this->data = $this->serializer->deserialize(
            $request->getContent(),
            $model,
            self::RESPONSE_FORMAT
        );

        $violations = $this->validator->validate($this->data);

        if ($violations->count() > 0) {
            $errors = [];
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errors[Inflector::tableize($violation->getPropertyPath())] = $violation->getMessage();
            }

            throw new ValidationException(
                $this->encodeError($errors),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    protected function persist($data = null)
    {
        $this->getDoctrine()->getManager()->persist($data);
        $this->getDoctrine()->getManager()->flush();
    }

    protected function viewSerialized($serializedObject, Array $contextItems = [])
    {
        $context = new Context();
        $context->addGroups($contextItems);
        $view = $this->view($serializedObject);
        return $view->setContext($context);
    }

    private function encodeError(array $errors): string
    {
        return json_encode(['errors' => $errors]);
    }

}
