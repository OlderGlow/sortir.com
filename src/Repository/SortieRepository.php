<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Participants;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     *  Récupère les sorties en fonctions des recherches
     * @return Sorties[]
     */
    public function findSearch(SearchData $search, UserInterface $participants): array
    {
        $query = $this
            ->createQueryBuilder('s')
            ->select('o', 's', 'c', 'p')
            ->leftJoin('s.organisateur', 'o')
            ->leftJoin('s.campus', 'c')
            ->leftJoin('s.estInscrit', 'p');

        if(!empty($search->campus)){
            $query = $query
                ->andWhere('c.id = :val')
                ->setParameter('val', $search->campus);
        }
        if(!empty($search->q)){
            $query = $query
                ->andWhere('s.nom LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if($search->sortieOrganisateur == true){
            $query = $query
                ->andWhere('o.id = :val')
                ->setParameter('val', $participants);
        }
        if($search->sortieInscrit == true){
            $query = $query
                ->andWhere('p.id = :val')
                ->setParameter('val', $participants);
        }

        if($search->noInscrit == true){
            $query = $query
                ->andWhere('p.id != :val')
                ->setParameter('val', $participants);
        }

        //SELECT * FROM sorties AS s LEFT JOIN participant_sortie AS p ON s.id = p.sortie_id WHERE p.participant_id != 4

        if(!empty($search->dateStart)){
            $query = $query
                ->andWhere('s.datedebut >= :val')
                ->setParameter('val', $search->dateStart);
        }

        if(!empty($search->dateEnd)){
            $query = $query
                ->andWhere('s.datecloture >= :value')
                ->setParameter('value', $search->dateEnd);
        }


        if(!empty($search->datePasse)){
            $query = $query
                ->andWhere('e.libelle = :val')
                ->setParameter('val', 'Passée');
        }


         return $query->getQuery()->getResult();

    }
}
