<?php

namespace App\DataFixtures;

use App\Entity\ParamsRepeat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RepeatParamsFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(1, 'repeatParams', function () {
            $rp = new ParamsRepeat();
            $rp->setBase(1);
            $rp->setModifier(1);
            return $rp;
        });

        $manager->flush();
    }
}
