<?php

namespace App\DataFixtures;

use App\Entity\Deck;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'admin_decks', function () {
            $deck = new Deck($this->faker->name, $this->faker->text);
            /** @var User $user */
            $user = $this->getRandomReference('admin');
            $deck->setUser($user);
            return $deck;
        });

        $this->createMany(30, 'users_decks', function () {
            $deck = new Deck($this->faker->name, $this->faker->text);
            /** @var User $user */
            $user = $this->getRandomReference('users');
            $deck->setUser($user);
            return $deck;
        });

        $manager->flush();
    }



    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
