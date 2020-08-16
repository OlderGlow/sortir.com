<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Participants;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function findSearch(SearchData $search, Participants $participants): array
    {
        $query = $this
            ->createQueryBuilder('s')
            ->leftJoin('s.estInscrit', 'p')
            ->addSelect('p')
            ->leftjoin('s.organisateur', 'o')
            ->addSelect('o')
            ->leftJoin('s.campus', 'c')
            ->addSelect('c');

            //->addOrderBy('s.dateHeureDebut');

        if(!empty($search->campus)){
            $query = $query
                ->andWhere('c.id = :val')
                ->setParameter('val', $search->campus);
        }
        if(!empty($search->q)){
            $query = $query
                ->andWhere('p.nom LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        if(!empty($search->sortieOrganisateur)){
            $query = $query
                ->andWhere('o.id = :val')
                ->setParameter('val', $participants->getId());
        }
        if(!empty($search->sortieInscrit)){
            $query = $query
                ->andWhere('p.id = :val')
                ->setParameter('val', $participants->getId());
        }

        if(!empty($search->noInscrit)){
            $query = $query
                ->andWhere('p.id != :val')
                ->setParameter('val', $participants->getId());
        }

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
                ->leftJoin('s.etats', 'e')
                ->addSelect('e')
                ->andWhere('e.libelle = :val')
                ->setParameter('val', 'Passée');
        }


         return $query->getQuery()->getResult();

    }
}
