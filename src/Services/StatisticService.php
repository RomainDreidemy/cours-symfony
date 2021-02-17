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

    public function getEcartTypeForBeerClient()
    {
        $clients = $this->manager->getRepository(Client::class)->findAll();
        $average = $this->manager->getRepository(Statistic::class)->averageBuy();

        $ecarts = [];

        foreach ($clients as $client){
            $ecart_donnee = count($client->getStatistics()) - $average;
            $ecart_donnee_carre = bcpow($ecart_donnee, 2, 2);
            $ecarts[] = $ecart_donnee_carre;
        }
        $division = array_sum($ecarts) / count($clients);
        $ecart_type = bcsqrt($division, 2);

        return $ecart_type;
    }
}