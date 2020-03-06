<?php

namespace App\DataFixtures;

use App\Entity\Deck;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'decks', function ($i) {
            $deck = new Deck();
            $deck->setUser($this->getRandomReference('users'));
            $deck->setName($this->faker->name);
            $deck->setDescription($this->faker->text);
            $deck->setExtraLearning(10);
            $deck->setLimitLearning(10);
            $deck->setLimitRepeat(10);
            $deck->setParamsRepeat($this->getRandomReference('repeatParams'));

            return $deck;
        });


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            RepeatParamsFixture::class
        ];
    }
}
