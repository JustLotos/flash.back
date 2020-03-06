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
    $this->createMany(10, 'cards', function ($i) {
      $card= new Card();
      /** @var Deck $deck */
      $deck = $this->getRandomReference('decks');
      $card->setDeck($deck);
      $card->setName($this->faker->name);
      $card->setDateCreated($this->faker->dateTime('now'));
      $card->setDateLastModified($this->faker->dateTime('now'));
      $card->setDifficultyIndex(1);
      $card->setDateNextRepeat($this->faker->dateTimeInInterval('1 month', '1 week'));
      return $card;
    });

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      DeckFixture::class
    ];
  }
}
