<?php

use App\Event\RegisteredUserEvent;
use App\Service\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{

  private $mailer;

  public function __construct(MailerService $mailer)
  {
    $this->mailer = $mailer;
  }

  public static function getSubscribedEvents()
  {
    return [
      RegisteredUserEvent::NAME => 'onUserRegister'
    ];
  }

  public function onUserRegister(RegisteredUserEvent $registeredUserEvent)
  {
    $this->mailer->sendConfirmationMessage($registeredUserEvent->getRegisteredUser());
  }
}