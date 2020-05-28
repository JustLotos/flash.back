<?php

declare(strict_types=1);

namespace App\Event;

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
        $error = $event->getThrowable();

        $this->logger->critical($error->getMessage());

        if ($error instanceof ApplicationException) {
            $response = $this->handleKnownExceptions($error);
        } elseif ($error instanceof AccessDeniedHttpException || $error instanceof NotFoundHttpException) {
            $response = $this->handle404($error);
        } else {
            $response = $this->handleUnknownExceptions($error);
        }

        $event->setResponse($response);
    }

    private function handle404(Throwable $exception)
    {
//        json_encode(['errors' => ['message' => str_replace('"', '\'', $exception->getMessage())]]),
        $response = new Response(
            $exception->getMessage(),
            Response::HTTP_NOT_FOUND
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function handleKnownExceptions(Throwable $exception)
    {
        $response = new Response($exception->getMessage(), $exception->getStatusCode());
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function handleUnknownExceptions(Throwable $exception) : Response
    {
//        var_dump( );;
//        json_encode(['errors' => ['message' => str_replace('"', '\'', $exception->getMessage())]]),
        $response = new Response(
            $exception->getMessage(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
