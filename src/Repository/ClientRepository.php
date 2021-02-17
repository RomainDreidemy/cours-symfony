<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function averageAge(): float
    {
        return floatval($this->createQueryBuilder('c')
            ->select('avg(c.age)')
            ->getQuery()
            ->getOneOrNullResult()[1])
        ;
    }

    public function haveAlreadyByABeer()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.statistics', 's')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOrderByCountBeer(string $order): array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.statistics', 's')
            ->groupBy('c')
            ->orderBy('COUNT(s.id)', $order)
            ->getQuery()
            ->getResult()
        ;
    }
}
