<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\Deck;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CardFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
//        $this->createMany(1000, 'cards', function () {
//            /** @var Deck $deck */
//            $deck = $this->getRandomReference('decks');
//
//            return new Card(
//                $this->faker->name,
//                $deck
//            );
//        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DeckFixture::class
        ];
    }
}
