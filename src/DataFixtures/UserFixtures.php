<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\User\Entity\Types\ConfirmToken;
use App\Model\User\Entity\Types\Id;
use App\Model\User\Entity\Types\Name;
use App\Model\User\Entity\Types\Role;
use App\Model\User\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class UserFixtures extends BaseFixture implements ContainerAwareInterface
{
    public const ADMINS = 'ADMINS';
    public const USERS = 'USERS';

    public function loadData(ObjectManager $manager) : void
    {
        $this->createMany(1, self::ADMINS, function () {
            $user = User::registerByEmail(
                Id::next(),
                new DateTimeImmutable(),
                Role::admin(),
                new ConfirmToken('token2', new DateTimeImmutable('+1 hour')),
                'ignashov-roman@mail.ru',
                '12345678'
            );
            $user->activate();
            $user->changeName(new Name('Roman', 'Ignashov'));
            return $user;
        });

        $this->createMany(1, self::USERS, function () {
            $user = User::registerByEmail(
                Id::next(),
                new DateTimeImmutable(),
                Role::user(),
                new ConfirmToken('token1', new DateTimeImmutable('+1 hour')),
                'test$i@mail.com',
                '12345678'
            );
            $user->activate();
            return $user;
        });

        $manager->flush();
    }
}
