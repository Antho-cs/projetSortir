<?php

namespace App\Repository;

use App\Entity\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Participants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participants[]    findAll()
 * @method Participants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantsRepository extends ServiceEntityRepository  implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participants::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Participants) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Participants[] Returns an array of Participants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Participants
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function loadUserByUsername(string $PseudoOrMail)
    {

        return $this->createQueryBuilder('p')
            ->where('p.mail = :val')
            ->orWhere('p.Pseudo = :val')
            ->setParameter('val', $PseudoOrMail)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*
    public function loadUserByPseudoOrMail($usernameOrEmail)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT participant
                FROM App\Entity\Participants participant
                WHERE participant.Pseudo = :query
                OR participant.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }
    */
}
