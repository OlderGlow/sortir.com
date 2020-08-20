<?php

namespace App\DataFixtures;

use App\Entity\Etats;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixture extends Fixture
{
    public const ETAT_NAME = ['Créée', 'Ouverte', 'Clôturée', 'Activité en cours', 'Passée', 'Annulée'];
    public function load(ObjectManager $manager)
    {


        for ($i = 0; $i < count(self::ETAT_NAME); $i++)
        {
            $etat = new Etats();
            $etat->setLibelle(self::ETAT_NAME[$i]);
            $manager->persist($etat);
            $this->addReference(self::ETAT_NAME[$i], $etat);
        }


        $manager->flush();
    }
}
