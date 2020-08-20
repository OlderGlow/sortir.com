<?php


namespace App\Service;


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
}