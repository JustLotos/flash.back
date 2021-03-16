<?php

declare(strict_types=1);

namespace App\Service\MailService;

use App\Domain\User\Entity\Types\Email;

trait MailTrait
{
    private static function getDefaultUrl():string
    {
        return getenv('DEFAULT_HOST');
    }

    private static function getDefaultFromAddress(): Email
    {
        return new Email('ignashov-roman@mail.ru');
    }
}
