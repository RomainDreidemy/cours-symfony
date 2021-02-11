<?php

namespace App\DataFixtures;

use App\Services\CategoryService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categoriesNormals = ['blonde', 'brune', 'blanche'];
        $categoriesSpecials = ['houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'] ;

        foreach ($categoriesNormals as $categorieNormal){
            $this->categoryService->create(
                $categorieNormal,
                $faker->text('400'),
                'normal'
            );
        }

        foreach ($categoriesSpecials as $categorieSpecial){
            $this->categoryService->create(
                $categorieSpecial,
                $faker->text('400'),
                'special'
            );
        }
    }
}
