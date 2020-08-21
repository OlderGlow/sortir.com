<?php


namespace App\Service;


use App\Entity\Participants;
use App\Entity\Sorties;
use App\Repository\EtatsRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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
        if ($char == 0 && $i == 0 && $time == 0)
            return $now;


        if ($char === '+') {
            $now->modify($char . $i . $time);
        }
        return $now;
    }


    public function Etats(): void
    {
        $date = $this->dateUpdate(0, 0, 0);
        $sorties = $this->sortieRepository->findAll();
        $nmbr = count($sorties);
        $cloturee = $this->etatsRepository->findOneBy(['libelle' => 'Clôturée']);
        $enCour = $this->etatsRepository->findOneBy(['libelle' => 'Activité en cours']);
        $annule = $this->etatsRepository->findOneBy(['libelle' => 'Annulée']);
        $ouverte = $this->etatsRepository->findOneBy(['libelle' => 'Ouverte']);
        $passee = $this->etatsRepository->findOneBy(['libelle' => 'Passée']);
        for ($i = 0; $i < $nmbr; $i++) {
            if($sorties[$i]->getEtats()->getLibelle() == $ouverte->getLibelle()) {
                if ($sorties[$i]->getEstInscrit()->count() == $sorties[$i]->getNbInscriptionsMax()||
                    $sorties[$i]->getDatecloture()->format("m.d.y h:m") < date("m.d.y h:m" ))
                {
                    $sorties[$i]->setEtats($cloturee);
                    $this->em->persist($sorties[$i]);
                }
            }
            elseif($sorties[$i]->getEtats()->getLibelle() == $cloturee->getLibelle()) {
                if($sorties[$i]->getDatedebut()->format("m.d.y h:m") == date("m.d.y h:m")){
                    $sorties[$i]->setEtats($enCour);
                    $this->em->persist($sorties[$i]);
                }
                if ($sorties[$i]->getEstInscrit()->count() < $sorties[$i]->getNbInscriptionsMax() &&
                    $sorties[$i]->getDatecloture()->format("m.d.y h:m") > date("m.d.y h:m" ))
                {
                    $sorties[$i]->setEtats($ouverte);
                    $this->em->persist($sorties[$i]);
                }
                elseif ($sorties[$i]->getDatedebut()->format("m.d.y h:m") < date("m.d.y h:m")) {
                    if (date_add($sorties[$i]->getDatedebut(),
                            new \DateInterval("PT{$sorties[$i]->getDuree()}M")) < new \DateTime()) {
                        $sorties[$i]->setEtats($passee);
                        $this->em->persist($sorties[$i]);
                    }
                }
            }
            elseif($sorties[$i]->getEtats()->getLibelle() == $enCour->getLibelle()) {
                if ($sorties[$i]->getDatecloture()->format("m.d.y h:m") < date("m.d.y h:m" ))
                {
                    $sorties[$i]->setEtats($cloturee);
                    $this->em->persist($sorties[$i]);
                }
                if (date_add($sorties[$i]->getDatedebut(),
                        new \DateInterval("PT{$sorties[$i]->getDuree()}M")) < new \DateTime()) {
                    $sorties[$i]->setEtats($passee);
                    $this->em->persist($sorties[$i]);
                }
            }
            $this->em->flush();
        }
    }
}