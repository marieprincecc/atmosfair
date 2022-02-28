<?php

namespace App\Repository;

use PDO;
use App\Entity\Opinions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    
    public function findForHome()
    {
        return $this->createQueryBuilder('o')
           
            
            ->orderBy('o.stars', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function starsAvg()
    {
        return $this->createQueryBuilder('o')
            ->select('AVG(o.stars)')
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
