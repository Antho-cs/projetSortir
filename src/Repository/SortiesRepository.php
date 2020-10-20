<?php

namespace App\Repository;

use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    // Vérifier si le nom de la ville contient la string passée en argument
    public function contains($recherche)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nom LIKE :r')
            ->setParameter('r', '%'.$recherche.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByDate($dateDebut, $dateFin)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut BETWEEN :dd AND :df')
            ->setParameter('dd', $dateDebut)
            ->setParameter('df', $dateFin)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Sorties[] Returns an array of Sorties objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sorties
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
