<?php

namespace App\Repository;

use App\Entity\Crossword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Crossword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crossword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crossword[]    findAll()
 * @method Crossword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrosswordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Crossword::class);
    }

    // /**
    //  * @return Crossword[] Returns an array of Crossword objects
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
    public function findOneBySomeField($value): ?Crossword
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
