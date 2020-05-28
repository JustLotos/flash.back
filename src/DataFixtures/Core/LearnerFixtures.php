<?php

declare(strict_types=1);

namespace App\DataFixtures\Core;

use App\DataFixtures\BaseFixture;
use App\DataFixtures\UserFixtures;
use App\Model\Core\Entity\Learner\Learner;
use App\Model\Core\Entity\Learner\Types\Id as LearnerId;
use App\Model\User\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LearnerFixtures extends BaseFixture implements DependentFixtureInterface
{
    public const ADMIN_LEARNERS = 'ADMIN_LEARNERS';
    public const USER_LEARNERS = 'USER_LEARNERS';

    public function loadData(ObjectManager $manager) : void
    {
        $this->createMany(1, self::ADMIN_LEARNERS, function () {
            /** @var Learner $user */
            $user = $this->getRandomReference(UserFixtures::ADMINS);
            return Learner::create(new LearnerId($user->getId()->getValue()));
        });

        $this->createMany(1, self::USER_LEARNERS, function () {
            /** @var User $user */
            $user = $this->getRandomReference(UserFixtures::USERS);
            return Learner::create(new LearnerId($user->getId()->getValue()));
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
