<?php


namespace App\Service;


use App\Entity\Participants;
use App\Entity\Sorties;
use App\Repository\EtatsRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventManager
{

    /**
     * @var SortieRepository
     */
    private $sortieRepository;
    /**
     * @var EtatsRepository
     */
    private $etatsRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(SortieRepository $sortieRepository, EtatsRepository $etatsRepository, EntityManagerInterface $em)
    {
        $this->sortieRepository = $sortieRepository;
        $this->etatsRepository = $etatsRepository;
        $this->em = $em;
    }

    public function dateUpdate($char, $i, $time)
    {
        $now = new \DateTime('now');
        if($char == 0 && $i == 0 && $time == 0)
            return $now;


        if($char === '+')
        {
            $now->modify($char.$i.$time);
        }
        return $now;
    }

    public function toPasse(): void
    {
        $sorties = $this->sortieRepository->findAll();
        $nmbr = count($sorties);
        $etat = $this->etatsRepository->findOneBy(['libelle' => 'Passée']);
        $date = $this->dateUpdate(0,0,0);
        for ($i = 0; $i < $nmbr; $i++)
        {
            if($sorties[$i]->getDatedebut() < $date)
            {
                $sorties[$i]->setEtats($etat);
            }
        }
        $this->em->flush();
    }

    public function inscriptionMax(): void
    {
        $date = $this->dateUpdate(0,0,0);
        $sorties = $this->sortieRepository->findAll();
        $nmbr = count($sorties);
        $cloturee = $this->etatsRepository->findOneBy(['libelle' => 'Clôturée']);
        $enCour = $this->etatsRepository->findOneBy(['libelle' => 'Activité en cours']);
        $annule = $this->etatsRepository->findOneBy(['libelle' => 'Annulée']);
        $ouverte = $this->etatsRepository->findOneBy(['libelle' => 'Ouverte']);
        for ($i = 0; $i < $nmbr; $i++)
        {
            if($sorties[$i]->getEtats() == $ouverte)
            {
                if(count($sorties[$i]->getEstInscrit()) >= $sorties[$i]->getNbinscriptionsmax())
                {
                    $sorties[$i]->setEtats($cloturee);
                }
                elseif (count($sorties[$i]->getEstInscrit()) < $sorties[$i]->getNbinscriptionsmax())
                {
                    $sorties[$i]->setEtats($ouverte);
                }
            }
            if($sorties[$i]->getDatecloture() < $date)
            {
                $sorties[$i]->setEtats($cloturee);
            }

            // Modifier la date pour jour et heure
            if($sorties[$i]->getDatedebut() == $date && $sorties[$i]->getEtats() != $annule)
            {
                $sorties[$i]->setEtats($enCour);
            }

        }
        $this->em->flush();
    }
}