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

        /** @var Client $client */
        foreach ($clients as $client){
            $ecart_donnee = count($client->getStatistics()) - $average;
            $ecart_donnee_carre = bcpow($ecart_donnee, 2, 2);
            $ecarts[] = $ecart_donnee_carre;
        }
        $division = array_sum($ecarts) - count($clients);
        $ecart_type = bcsqrt($division, 2);

        return $ecart_type;
    }

    public function ecart_type ($donnees) {
        //0 - Nombre d’éléments dans le tableau
        $population = count($donnees);
        if ($population != 0) {
            //1 - somme du tableau
            $somme_tableau = array_sum($donnees);
            //2 - Calcul de la moyenne
            $moyenne = $somme_tableau / $population;
            //3 - écart pour chaque valeur
            $ecart = [];
            for ($i = 0; $i < $population; $i++){
                //écart entre la valeur et la moyenne
                $ecart_donnee = $donnees[$i] - $moyenne;
                //carré de l'écart
                $ecart_donnee_carre = bcpow($ecart_donnee, 2, 2);
                //Insertion dans le tableau
                array_push($ecart, $ecart_donnee_carre);
            }
            //4 - somme des écarts
            $somme_ecart = array_sum($ecart);
            //5 - division de la somme des écarts par la population
            $division = $somme_ecart / $population;

            //6 - racine carrée de la division
            $ecart_type = bcsqrt ($division, 2);
        } else {
            $ecart_type = "Le tableau est vide";
        }
        //7 - renvoi du résultat
        return $ecart_type;
    }
}