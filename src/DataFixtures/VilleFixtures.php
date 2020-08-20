<?php

namespace App\DataFixtures;

use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{

    public const VILLE = ['Angers', 'Nantes', 'Marseille', 'Monaco', 'Bordeaux', 'Paris'];
    public const CODE_POSTAL = ['49000', '44000', '13000', '98000', '33000', '75000'];

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < count(self::VILLE); $i++) {
            $ville = new Villes();
            $ville->setNomVille(self::VILLE[$i]);
            $ville->setCodePostal(self::CODE_POSTAL[$i]);
            $manager->persist($ville);
            $this->addReference(self::VILLE[$i], $ville);
        }
        $manager->flush();
    }
}
