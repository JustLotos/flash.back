<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailerService
{
    public const FROM_ADDRESS = 'kafkiansky@webshake.ru';
    private $mailer;
    private $twig;
    private $router;

    public function __construct(
        MailerInterface $mailer,
        TwigService $twig,
        UrlGeneratorInterface $router
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function sendConfirmationMessage(User $user)
    {
        $messageBody = $this->twig->render(
            'security/confirmation.html.twig',
            [
                'user' => $user,
                'link' => $this->router->generate(
                    'register_confirm',
                    ['confirmationCode' => $user->getConfirmationCode()]
                )
            ]
        );

        $email = (new Email())
            ->from(self::FROM_ADDRESS)
            ->to($user->getEmail())
            ->subject('Регистрация в приложении Flash')
            ->text('Подтверждение регистрации')
            ->html($messageBody);
        $this->mailer->send($email);
    }
}