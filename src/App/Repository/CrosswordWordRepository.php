<?php

namespace App\Repository;

use App\Entity\CrosswordWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CrosswordWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrosswordWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrosswordWord[]    findAll()
 * @method CrosswordWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrosswordWordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CrosswordWord::class);
    }

    // /**
    //  * @return CrosswordWord[] Returns an array of CrosswordWord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CrosswordWord
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
