<?php

namespace App\Repository;

use App\Entity\Gazouillis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gazouillis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gazouillis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gazouillis[]    findAll()
 * @method Gazouillis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GazouillisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gazouillis::class);
    }

    // /**
    //  * @return Gazouillis[] Returns an array of Gazouillis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gazouillis
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
