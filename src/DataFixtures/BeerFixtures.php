<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Services\BeerService;
use App\Services\CategoryService;
use App\Services\CountryService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BeerFixtures extends Fixture implements DependentFixtureInterface
{
    private $beerService;
    private $categoryService;
    private $countryService;

    public function __construct(BeerService $beerService, CategoryService $categoryService, CountryService $countryService)
    {
        $this->beerService = $beerService;
        $this->categoryService = $categoryService;
        $this->countryService = $countryService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categoriesNormal = $manager->getRepository(Category::class)->findByTerm('normal');
        $categoriesSpecial = $manager->getRepository(Category::class)->findByTerm('special');

        $countries = $this->countryService->getAll();

        for ($i = 0; $i < 10; $i++){
            $categories = $faker->randomElements($categoriesSpecial, 2);
            $categories[] = $faker->randomElement($categoriesNormal);

            $this->beerService->create(
                $faker->name,
                $faker->dateTime,
                $faker->text('200'),
                $faker->randomFloat(2, 10.00, 500.00),
                $faker->randomElements($categories, 2, false),
                $faker->randomElement($countries)
            );
        }
    }

    public function getDependencies(): array
    {
        return [ CategoryFixtures::class, CountryFixtures::class ];
    }
}
