<?php

declare(strict_types=1);

namespace App\Domain\User\Events;

use App\Domain\User\Entity\User;
use DomainException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Flash\User\UserInterface;

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
