<?php

declare(strict_types=1);

namespace App\Event\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundListener implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::JWT_NOT_FOUND => 'onJWTNotFound',
        ];
    }

    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $error['errors'] = [
            'token' => 'Токен не найден для продолжения работы вам необходимо авторизоваться'
        ];
        $response = new Response(json_encode($error), Response::HTTP_UNAUTHORIZED);
        $event->setResponse($response);
    }
}
