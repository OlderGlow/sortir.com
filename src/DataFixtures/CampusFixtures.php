<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{

    public const CAMPUS_NAME = ['OPENCLASSROOMS', 'CEFII', 'OCLOCK', 'CEFOC', 'SACREE COEUR', 'ENI'];

    public function load(ObjectManager $manager)
    {


        for ($i = 0; $i < count(self::CAMPUS_NAME); $i++) {
            $campus = new Campus();
            $campus->setNomCampus(self::CAMPUS_NAME[$i]);
            $manager->persist($campus);
            $this->addReference(self::CAMPUS_NAME[$i], $campus);
        }

        $manager->flush();


    }
}