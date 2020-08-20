<?php

namespace App\DataFixtures;

use App\Entity\Lieux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LieuxFixtures extends Fixture implements DependentFixtureInterface
{

    public const LIEUX = ['Cinéma', 'Pationoire', 'Shopping', 'Concert', 'Salle de sport', 'Café'];
    public const RUE = ['Rue des cheminots', 'Rue du Haras', 'Place du Ralliement', 'Bd Carnot', 'Rue du Mail', 'Rue de Petit Prés'];
    public const LATITUDE = ['45.38403', '04.482930', '39.483940', '10.48290', '98.73829', '45.29184'];
    public const LONGETIDUE = ['98.73829', '45.29184', '10.48290', '39.483940', '45.38403', '04.482930'];

    public function load(ObjectManager $manager)
    {


        for ($i = 0; $i < count(self::LIEUX); $i++) {
            $lieux = new Lieux();
            $lieux->setNomLieu(self::LIEUX[$i]);
            $lieux->setRue(self::RUE[$i]);
            $lieux->setLatitude(self::LATITUDE[$i]);
            $lieux->setLongitude(self::LONGETIDUE[$i]);
            $lieux->setVille($this->getReference(VilleFixtures::VILLE[$i]));
            $this->addReference(self::LIEUX[$i], $lieux);
            $manager->persist($lieux);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            VilleFixtures::class,
        );
    }
}
