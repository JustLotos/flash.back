<?php

declare(strict_types=1);

namespace App\Domain\User\Entity\Types;

use Webmozart\Assert\Assert;

class Email
{
    private $value;

    public function __construct(string $value, int $length = 8)
    {
        Assert::email($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $email): bool
    {
        return $this->value === $email->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
