<?php

declare(strict_types=1);

namespace App\DataFixtures\Flash;

use App\DataFixtures\User\UserFixtures;
use App\Domain\Flash\Learner\Entity\Learner;
use App\Domain\Flash\Learner\Entity\Types\Id;
use App\Domain\User\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\BaseFixture;

class LearnerFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const ADMINS = self::class.'_ADMINS';
    public const USERS = self::class.'USERS';

    public function loadData(ObjectManager $manager) : void
    {
        $this->createMany(1, self::ADMINS, function () {
            /** @var User $user */
            $user = $this->getRandomReference(UserFixtures::ADMINS);
            $id = new Id($user->getId()->getValue());
            return new Learner($id);
        });

        $this->createMany(1, self::USERS, function () {
            /** @var User $user */
            $user = $this->getRandomReference(UserFixtures::USERS);
            $id = new Id($user->getId()->getValue());
            return new Learner($id);
        });

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
