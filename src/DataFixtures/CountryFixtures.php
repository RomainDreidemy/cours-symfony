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
        $countries = ['belgium', 'french', 'English', 'germany'];

        foreach ($countries as $country){
            $this->countryService->create(
                $country,
                $faker->address,
                $faker->email
            );
        }
    }
}
