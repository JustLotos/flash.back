<?php

declare(strict_types=1);

namespace App\Event\EventListener;

use DateTime;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use function json_decode;

class JWTCreatedListener implements EventSubscriberInterface
{
    public const REMEMBER_ME_EXPIRATION_DAYS = 30;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() : array
    {
        return [Events::JWT_CREATED => 'onJWTCreated'];
    }

    /**
     * @throws Exception
     */
    public function onJWTCreated(JWTCreatedEvent $event) : void
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request->getContentType() !== 'json') {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['remember_me'])) {
            return;
        }

        $expiration = new DateTime('+' . self::REMEMBER_ME_EXPIRATION_DAYS . ' days');

        $payload        = $event->getData();
        $payload['exp'] = $expiration->getTimestamp();

        $event->setData($payload);
    }
}
