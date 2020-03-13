<?php

declare(strict_types=1);

namespace App\Event\EventListener;

use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccessResponse'];
    }

    /**
     * @throws Exception
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) : void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (! $user instanceof UserInterface) {
            return;
        }

        $data['roles'] = $user->getRoles();

        $event->setData($data);
    }
}
