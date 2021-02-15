<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Services\ClientService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    private $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++){
            $this->clientService->create($faker->name, $faker->email, $faker->randomFloat(2, 60, 100), random_int(16, 100));
        }
    }
}
