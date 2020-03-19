<?php

declare(strict_types=1);

namespace App\Event\Auth\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailureListener implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailureResponse'];
    }

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event) : void
    {
        $data = [
            'errors' => ['message' => 'Пользователь с таким email-адресом и паролем не найден'],
        ];

        $response = new Response(json_encode($data), Response::HTTP_UNAUTHORIZED);

        $event->setResponse($response);
    }
}
