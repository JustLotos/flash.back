<?php

declare(strict_types=1);

namespace App\DataFixtures\Core;

use App\DataFixtures\BaseFixture;
use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Entity\Deck\Types\Settings;
use App\Model\Core\Entity\Learner\Learner;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixture extends BaseFixture implements DependentFixtureInterface
{
    public const ADMIN_DECKS = 'ADMIN_DECKS';
    public const USER_DECKS = 'USER_DECKS';

    public function loadData(ObjectManager $manager) : void
    {
        $this->createMany(2, self::ADMIN_DECKS, function () {
            /** @var Learner $learner */
            $learner = $this->getRandomReference(LearnerFixtures::ADMIN_LEARNERS);
            return $this->getBaseDeck($learner);
        });

        $this->createMany(2, self::USER_DECKS, function () {
            /** @var Learner $learner */
            $learner = $this->getRandomReference(LearnerFixtures::USER_LEARNERS);
            return $this->getBaseDeck($learner);
        });
        $manager->flush();
    }

    private function getBaseDeck(Learner $learner): Deck
    {
        $settings = new Settings(
            new DateInterval('PT1H'),
            new DateInterval('PT30S'),
            $this->faker->numberBetween(10, 40),
            $this->faker->numberBetween(10, 40),
            $this->faker->randomFloat(2, 0.5, 4)
        );

        return new Deck($learner, $this->faker->name(), $settings, new DateTimeImmutable(), $this->faker->realText());
    }

    public function getDependencies()
    {
        return [LearnerFixtures::class];
    }
}
