<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CardFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager) : void
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
        return [DeckFixture::class];
    }
}
