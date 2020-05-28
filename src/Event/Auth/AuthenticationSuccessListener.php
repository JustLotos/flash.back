<?php

declare(strict_types=1);

namespace App\Event\Auth;

use App\Model\User\Entity\User;
use DomainException;
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

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) : void
    {
        $data = $event->getData();
        /** @var User $user */
        $user = $event->getUser();
        if (! $user instanceof UserInterface) {
            throw new DomainException('Required class implements '. UserInterface::class .', '.get_class($user). ' given');
        }

        $data['role'] = $user->getRoles()[0];
        $event->setData($data);
    }
}
