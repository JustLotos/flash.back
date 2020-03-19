<?php

declare(strict_types=1);

namespace App\Event\EventListener;

use App\Exception\ApplicationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class HTTPExceptionListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event) : void
    {
        if ($event->getThrowable() instanceof ApplicationException) {
            $response = $this->handleKnownExceptions($event->getThrowable());
        } else {
            $response = $this->handleUnknownExceptions($event->getThrowable());
        }

        $event->setResponse($response);
    }

    private function handleKnownExceptions(Throwable $exception)
    {
        $response = new Response($exception->getMessage(), $exception->getStatusCode());
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function handleUnknownExceptions($exception) : Response
    {
        return new Response(
            json_encode(['errors' => ['message' => str_replace('"', '\'', $exception->getMessage())]]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
