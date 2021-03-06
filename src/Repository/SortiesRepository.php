<?php

namespace App\Repository;

use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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

    public function findByCriteria($campus, $nomSortie, $dateDebut, $dateFin, $organisateur, $inscrit, $noninscrit, $outdated)
    {
        $builder = $this->createQueryBuilder('q');
        if ($campus) {
            $builder->andWhere('q.campus = :c')
                ->setParameter('c', $campus);
        }
        if ($nomSortie) {
            $builder->andWhere('q.nom LIKE :r')
                ->setParameter('r', '%' . $nomSortie . '%');
        }
        if ($dateDebut) {
            $builder->andWhere('q.dateDebut >= :dd ')
                ->setParameter('dd', $dateDebut);
        }
        if ($dateFin) {
            $builder->andWhere('q.dateDebut <= :df')
                ->setParameter('df', $dateFin);
        }
        if ($organisateur) {
            $builder->andWhere('q.organisateur = :o')
                ->setParameter('o', $organisateur);
        }
        if ($inscrit) {
            $builder->join('q.inscriptions', 'p')
                ->andWhere('p.participant = :ok')
                ->setParameter('ok', $inscrit);
        }
        if ($noninscrit) { //NOTE Je n'aurais pas trouvé seul
            $builder->where(
                $builder->expr()->notIn('q.id',
                    $this->createQueryBuilder('sq')
                        ->select('sq.id')
                        ->join('sq.inscriptions', 'i')
                        ->where('i.participant = :p')
                        ->getDQL()
                )
            )->setParameter('p', $noninscrit);
        }
        if ($outdated) {
            $builder->andWhere('q.dateDebut < :n')
                ->setParameter('n', $outdated);
        }
        return $builder->getQuery()
            ->getResult();
    }

//    public function findInscriptions($sortie) {
//        return $this->createQueryBuilder('s')
//            ->join('s.inscriptions', 'i')
//            ->andWhere('i.sortie = :s')
//            ->setParameter('s', $sortie)
//            ->getQuery()
//            ->getResult()
//            ;
//    }
//    // Vérifier si le nom de la ville contient la string passée en argument
//    public function contains($recherche)
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.nom LIKE :r')
//            ->setParameter('r', '%'.$recherche.'%')
//            ->getQuery()
//            ->getResult()
//            ;
//    }
//
//    public function findByDate($dateMin, $dateMax)
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.dateDebut BETWEEN :dd AND :df')
//            ->setParameter('dd', $dateMin)
//            ->setParameter('df', $dateMax)
//            ->getQuery()
//            ->getResult();
//    }
//    public function findAfterDate($dateMin)
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.dateDebut >= :dd ')
//            ->setParameter('dd', $dateMin)
//            ->getQuery()
//            ->getResult();
//    }
//    public function findBeforeDate($dateMax)
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.dateDebut <= :df')
//            ->setParameter('df', $dateMax)
//            ->getQuery()
//            ->getResult()
//            ;
//    }

//SELECT DISTINCT value FROM `table1`
//WHERE value IN (
//SELECT value
//FROM `table2`
//);

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
