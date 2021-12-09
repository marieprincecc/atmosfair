<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\Query;
use App\Search\SearchProduct;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

     /**
    * @param SearchProduct $search
    * @return Query
    */
    public function findAllBySearchFilter(SearchProduct $search): Query
    {

        $query = $this->findAllQuery();

        if($search->getFilterByName()) {
            $query = $query->andWhere('p.name LIKE :name');
            $query->setParameter('name', '%' . $search->getFilterByName() . '%');
            } 

        if($search->getFilterByRooms()) {
             $query = $query->andWhere('p.rooms = :rooms_id');
            $query->setParameter('rooms_id', $search->getFilterByRooms()->getId());
        }

        if($search->getFilterByPolluting()) {
            $query = $query->andWhere('p.polluting = :polluting_id');
           $query->setParameter('polluting_id', $search->getFilterByPolluting()->getId());
       }

        $query->addOrderBy('p.id', 'DESC');
        return $query->getQuery();
        }

        /**
        * @return QueryBuilder
        */
        public function findAllQuery(): QueryBuilder
        {
        return $this->createQueryBuilder('p');
        } 
    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
