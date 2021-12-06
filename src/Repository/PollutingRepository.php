<?php

namespace App\Repository;

use App\Entity\Polluting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Polluting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Polluting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Polluting[]    findAll()
 * @method Polluting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollutingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Polluting::class);
    }

    // /**
    //  * @return Polluting[] Returns an array of Polluting objects
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
    public function findOneBySomeField($value): ?Polluting
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
