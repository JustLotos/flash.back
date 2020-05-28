<?php

declare(strict_types=1);

namespace App\Model\Core\Events;

use App\Model\Core\UseCase\Learner\Create\CreateHandler;
use App\Model\User\Events\UserCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $handler;

    public function __construct(CreateHandler $handler)
    {
        $this->handler = $handler;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserCreatedEvent::NAME => 'onUserCreated',
        ];
    }

    public function onUserCreated(UserCreatedEvent $event)
    {
        $this->handler->handle($event->getUser());
    }
}