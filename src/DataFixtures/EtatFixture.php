<?php

namespace App\DataFixtures;

use App\Entity\Etats;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etatName = ['Créée', 'Ouverte', 'Clôturée', 'Activité en cours', 'Passée', 'Annulée'];

        for ($i = 0; $i < count($etatName); $i++)
        {
            $etat = new Etats();
            $etat->setLibelle($etatName[$i]);
            $manager->persist($etat);
        }


        $manager->flush();
    }
}
