<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    /**
     * WordRepository constructor.
     * @param ManagerRegistry $registry Manager registry.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

    /**
     * @param array $chars      Chars from which to make a word.
     * @param array $subQueries Sub Queries.
     * @return mixed
     */
    public function findWithChars(array $chars, array $subQueries)
    {
        $query = $this->createQueryBuilder('w');

        foreach ($subQueries as $subQuery) {
            $query->OrWhere($subQuery);
        }

        return $query->getQuery()->getResult();
    }
}
