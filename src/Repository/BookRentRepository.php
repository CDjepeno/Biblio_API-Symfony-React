<?php

namespace App\Repository;

use App\Entity\BookRent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookRent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookRent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookRent[]    findAll()
 * @method BookRent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookRent::class);
    }

    // /**
    //  * @return BookRent[] Returns an array of BookRent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookRent
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
