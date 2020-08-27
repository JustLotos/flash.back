<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\User\Entity\Types\ConfirmToken;
use App\Domain\User\Entity\Types\Email as UserEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailSenderService
{
    private $mailer;
    private $twig;
    private $generator;

    public function __construct(TwigService $twig, MailerInterface $mailer, UrlGeneratorInterface $generator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->generator = $generator;
    }

    public function registerConfirm(UserEmail $userEmail, ConfirmToken $token) : void
    {
        $url = self::getDefaultUrl().$this->generator->generate('registerConfirm', ['token' => $token->getToken()]);
        $messageBody = $this->twig->render('mail/user/email.html.twig', ['url' => $url]);

        $email = (new Email())
            ->from(self::getDefaultFromAddress())
            ->to($userEmail->getValue())
            ->subject('Регистрация в приложении Flash')
            ->text('Подтверждение регистрации')
            ->html($messageBody);
        $this->mailer->send($email);
    }

    public function resetPasswordConfirm(UserEmail $userEmail, ConfirmToken $token) : void
    {
        $url = self::getDefaultUrl().$this->generator->generate('resetPasswordConfirm', ['token' => $token->getToken()]);
        $messageBody = $this->twig->render('mail/user/resetPassword.html.twig', ['url'=> $url]);

        $email = (new Email())
            ->from(self::getDefaultFromAddress())
            ->to($userEmail->getValue())
            ->subject('Восстановление доступа в приложении Flash Back')
            ->text('Восстановление доступа в приложении Flash Back')
            ->html($messageBody);
        $this->mailer->send($email);
    }

    private static function getDefaultUrl():string
    {
        return getenv('DEFAULT_HOST');
    }

    private static function getDefaultFromAddress(): string
    {
        return getenv('DEFAULT_ADDRESS_FROM');
    }

}
