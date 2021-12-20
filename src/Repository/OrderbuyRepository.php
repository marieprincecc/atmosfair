<?php

namespace App\Repository;

use App\Entity\Orderbuy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orderbuy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orderbuy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orderbuy[]    findAll()
 * @method Orderbuy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderbuyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orderbuy::class);
    }

    // /**
    //  * @return Orderbuy[] Returns an array of Orderbuy objects
    //  */
    
    public function findByUser($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.user = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Orderbuy
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
