<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Services\StatisticService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StatisticFixtures extends Fixture implements DependentFixtureInterface
{
    private $statisticService;
    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $clients = $manager->getRepository(Client::class)->findAll();
        $beers = $manager->getRepository(Beer::class)->findAll();

        foreach ($clients as $client)
        {
            $nb = random_int(0, 3);

            for ($i = 0; $i < $nb; $i++){
                $this->statisticService->create(
                    $faker->randomElement($beers),
                    $client,
                    random_int(0, 10)
                );
            }
        }
    }

    public function getDependencies()
    {
        return [ClientFixtures::class, BeerFixtures::class];
    }
}
