<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Deck;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use function assert;

class DeckFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager) : void
    {
        $this->createMany(10, 'admin_decks', function () {
            $deck = new Deck($this->faker->name, $this->faker->text);
            $user = $this->getRandomReference('admin');
            assert($user instanceof User);
            $deck->setUser($user);

            return $deck;
        });

        $this->createMany(30, 'users_decks', function () {
            $deck = new Deck($this->faker->name, $this->faker->text);
            $user = $this->getRandomReference('users');
            assert($user instanceof User);
            $deck->setUser($user);

            return $deck;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
