<?php

namespace App\Repository;

use App\Entity\Statistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Statistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statistic[]    findAll()
 * @method Statistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    public function averageBuy(): float
    {
        $query = $this->createQueryBuilder('s')
            ->select('count(c.id) as Count')
            ->innerJoin('s.client', 'c')
            ->groupBy('c.id')
            ->getQuery()
            ->getSQL()
        ;

        $rawQuery = 'SELECT avg(sclr_0) as average FROM (' . $query . ') test';

        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare($rawQuery);
        $stmt->execute();

        return floatval($stmt->fetchOne());
    }

    public function averageScore(): float
    {
        return floatval($this->createQueryBuilder('s')
            ->select('avg(s.score)')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()[1])
        ;
    }

    public function higterScore()
    {
        return $this->createQueryBuilder('s')
            ->select('s.score')
            ->orderBy('s.score', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()['score']
        ;
    }

    public function lowerScore()
    {
        return $this->createQueryBuilder('s')
            ->select('s.score')
            ->orderBy('s.score', 'asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()['score']
        ;
    }

}
