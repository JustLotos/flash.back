<?php

declare(strict_types=1);

namespace App\Event\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class JWTExpiredListener implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::JWT_EXPIRED => 'onJWTExpired',
        ];
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event): void
    {
        $error['errors'] = [
            'token' => 'Время действия вашего токена истекло, пожайлуста обновите токен'
        ];
        $response = new Response(json_encode($error), Response::HTTP_UNAUTHORIZED);
        $event->setResponse($response);
    }
}
