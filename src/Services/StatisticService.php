<?php


namespace App\Services;


use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Statistic;
use Doctrine\ORM\EntityManagerInterface;

class StatisticService
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function create(Beer $beer, Client $client, int $score): Statistic
    {
        $statistic = (new Statistic())
            ->setBeer($beer)
            ->setClient($client)
            ->setScore($score)
        ;

        $this->manager->persist($statistic);
        $this->manager->flush();

        return $statistic;
    }
}