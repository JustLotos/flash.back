<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\Email;

use App\Model\User\Entity\User\Email;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Cloner\Data;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        $user->requestEmailChanging(
            'new@app.test',
            $token = 'token'
        );

        $user->confirmEmailChanging(new \DateTimeImmutable('now'));

        self::assertEquals('new@app.test', $user->getEmail());
        self::assertNull($user->getNewEmailToken());
        self::assertNull($user->getNewEmail());
    }

    public function testNotRequested(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        $this->expectExceptionMessage('Changing is not requested.');
        $user->confirmEmailChanging(new \DateTimeImmutable('now'));
    }

    public function testIncorrect(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        $user->requestEmailChanging(
            'new@app.test',
            'token'
        );

        $this->expectExceptionMessage('Incorrect changing token.');
        $user->confirmEmailChanging(new \DateTimeImmutable('now'));
    }
}
