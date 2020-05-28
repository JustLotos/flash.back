<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Core\Service;

use App\Model\Core\Entity\Card\Card;
use App\Model\Core\Entity\Card\Types\Record;
use App\Model\Core\Entity\Card\Types\IRepeat;
use App\Model\Core\Entity\Deck\Deck;
use App\Model\Core\Entity\Deck\Types\Settings;
use App\Model\Core\Entity\Learner\Types\Id;
use App\Model\Core\Service\AnswerMangerService\AnswerManagerService;
use App\Model\Core\Service\AnswerMangerService\DiscreteAnswer;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use App\Model\Core\Entity\Learner\Learner;

class AnswerManagerServiceTest extends TestCase
{
    private $learner;
    private $deck;
    private $card;
    private $ams;

    protected function setUp(): void
    {
        $this->ams = new AnswerManagerService();
        $this->learner = Learner::create(new Id('12345'));
        $settings = new Settings();
        $this->deck = new Deck($this->learner, 'name', $settings, new DateTimeImmutable());
        $front = Record::createFrontSide('some text');
        $back = Record::createBackSide('some text');
        $repeat = new IRepeat(
            new DateTimeImmutable(),
            $this->deck->getSettings()->getBaseInterval()
        );
        $this->card = Card::create($this->deck, 'name', $front, $back, $repeat, new DateTimeImmutable());
    }

    public function testSimpleIncreaseTimeRepeat(): void
    {
        $repeat = $this->card->getRepeat();
        self::assertEquals(Card::NEW, $this->card->getState());
        self::assertEquals(0, $repeat->getCount());
        self::assertEquals(0, $repeat->getSuccessCount());
        self::assertEquals(3600, $this->toSeconds($repeat->getRepeatInterval()));
        self::assertEquals(DateInterval::createFromDateString('0 seconds'), $repeat->getTotalTime());

        /** Первое повторение карточки */
        $date = new DateTimeImmutable('now');
        $initialTimeValue = 10;
        $time = DateInterval::createFromDateString($initialTimeValue.' seconds');
        $answer = new DiscreteAnswer($date, $time, DiscreteAnswer::REMEMBER);
        $interval = $this->ams->getRepeatInterval($this->card, $answer);
        $repeat->update($answer, $interval, $answer->isSuccess());
        $this->card->changeState();

        self::assertEquals($time, $repeat->getTotalTime());
        self::assertEquals($interval, $this->deck->getSettings()->getBaseInterval());
        self::assertEquals(Card::STUDIED, $this->card->getState());
        self::assertEquals(1, $repeat->getCount());
        self::assertEquals(1, $repeat->getSuccessCount());

        $sumTime = $initialTimeValue;
        for ($i=1, $j=1; $i<5; $i++, $j++) {
            $timeT = 10;
            $sumTime +=  $timeT;

            $answer = new DiscreteAnswer(
                $date,
                DateInterval::createFromDateString($timeT.' seconds'),
                DiscreteAnswer::KNOW
            );
            $interval = $this->ams->getRepeatInterval($this->card, $answer);

            $repeat->update($answer, $interval, $answer->isSuccess());
            $this->card->changeState();
            self::assertEquals(DateInterval::createFromDateString($sumTime. ' seconds'), $repeat->getTotalTime());
            self::assertEquals(Card::REPEATABLE, $this->card->getState());
            self::assertEquals($i+1, $repeat->getCount());
            self::assertEquals($i+1, $repeat->getSuccessCount());
        }
    }


    public function testSimpleDowngradeTimeRepeat(): void
    {
        $repeat = $this->card->getRepeat();

        /** Первое повторение карточки */
        $date = new DateTimeImmutable('now');
        $initialTimeValue = 10;
        $time = DateInterval::createFromDateString($initialTimeValue.' seconds');
        $answer = new DiscreteAnswer($date, $time, DiscreteAnswer::REMEMBER);
        $interval = $this->ams->getRepeatInterval($this->card, $answer);
        $repeat->update($answer, $interval, $answer->isSuccess());
        $this->card->changeState();

        self::assertEquals($time, $repeat->getTotalTime());
        self::assertEquals($interval, $this->deck->getSettings()->getBaseInterval());
        self::assertEquals(Card::STUDIED, $this->card->getState());
        self::assertEquals(1, $repeat->getCount());
        self::assertEquals(1, $repeat->getSuccessCount());

        $sumTime = $initialTimeValue;
        for ($i=1, $j=1; $i<5; $i++, $j++) {
            $timeT = $i*10;
            $sumTime +=  $timeT;

            $answer = new DiscreteAnswer(
                $date,
                DateInterval::createFromDateString($timeT.' seconds'),
                DiscreteAnswer::RECOGNIZE
            );
            $interval = $this->ams->getRepeatInterval($this->card, $answer);

            $repeat->update($answer, $interval, $answer->isSuccess());
            $this->card->changeState();
            self::assertEquals(DateInterval::createFromDateString($sumTime. ' seconds'), $repeat->getTotalTime());
            self::assertEquals(Card::REPEATABLE, $this->card->getState());
            self::assertEquals($i+1, $repeat->getCount());
            self::assertEquals(1, $repeat->getSuccessCount());
        }
    }

    
    private function formatDateIntervalOutput(DateInterval $interval, $name = '')
    {
        var_dump($name." - ".$interval->format('%m months %d days %h hours %m minute %s seconds'));
    }

    private function toSeconds(DateInterval $dateInterval): int
    {
        $startTime = new DateTimeImmutable();
        $endTime = $startTime->add($dateInterval);
        return $endTime->getTimestamp() - $startTime->getTimestamp();
    }
}
