<?php

namespace App\Repository;

use App\Entity\Opinions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Opinions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opinions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opinions[]    findAll()
 * @method Opinions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opinions::class);
    }

    /**
     * @return Opinions[] Returns an array of Opinions objects
     */
    public function findForHome()
    {
        return $this->createQueryBuilder('o')
           
            
            ->orderBy('o.stars', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Opinions
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
