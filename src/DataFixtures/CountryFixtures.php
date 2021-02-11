<?php

namespace App\DataFixtures;

use App\Services\CategoryService;
use App\Services\CountryService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CountryFixtures extends Fixture
{
    private $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 6; $i++){
            $this->countryService->create(
                $faker->name,
                $faker->address,
                $faker->email
            );
        }
    }
}
