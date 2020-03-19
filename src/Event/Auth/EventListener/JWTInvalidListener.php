<?php

namespace App\Event\Auth\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class JWTInvalidListener implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::JWT_INVALID => 'onJWTInvalid',
        ];
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $error['errors'] = ['message'=>'Ваш токен недействителен'];
        $response = new Response(json_encode($error), Response::HTTP_UNAUTHORIZED);

        $event->setResponse($response);
    }
}
