<?php

namespace App\DataFixtures;

use App\Entity\Sorties;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SortiesFixtures extends Fixture implements DependentFixtureInterface
{
    public const NOM = ['Avenger 4', 'Sortie Patinoire', 'Faisons les soldes', 'B20', 'Objectif Summer 2K', 'Pot de départ'];
    public const DESCRIPTION = ['Film des avengers 4 à voir en famille', 'Petite glissade entre amies samedi', 'Profitons des soldes aux galerires Lafayetters',
        'Concert de Booba au Palais des Congrets', 'Petite remise en forme object abdo pour le bord de la piscine', 'C\'est le départ de Miguel, il retourne en Espagne lundi prochain :('];
    public const DUREE = ['170', '60', '280', '120', '45', '30'];
    public const INSCRIT = [10, 8, 12, 5, 7, 20];
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::DESCRIPTION); $i++) {

            $sortie = new Sorties();
            $sortie->setNom(self::NOM[$i]);
            $sortie->setCampus($this->getReference(CampusFixtures::CAMPUS_NAME[$i]));
            $sortie->setDuree(self::DUREE[$i]);
            $sortie->setDatedebut(date_add(new \DateTime('now'), date_interval_create_from_date_string('+3 months')));
            $sortie->setDatecloture(date_add($sortie->getDatedebut(), date_interval_create_from_date_string('-5 days')));
            $sortie->setDescriptioninfos(self::DESCRIPTION[$i]);
            $sortie->setLieu($this->getReference(LieuxFixtures::LIEUX[$i]));
            $sortie->setNbinscriptionsmax(self::INSCRIT[$i]);
            $sortie->setOrganisateur($this->getReference(UserFixtures::USER_REFERENCE));
            $sortie->setEtats($this->getReference(EtatFixture::ETAT_NAME[$i]));

            $manager->persist($sortie);
            $this->addReference(self::NOM[$i], $sortie);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CampusFixtures::class,
            LieuxFixtures::class,
            UserFixtures::class
        );
    }
}
