<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Quote;
use App\Repository\ClientRepository;
use App\Services\StatisticService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class QuoteFixtures extends Fixture
{
    private $statisticService;
    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($faker));

        for ($i = 0; $i < 10; $i++) {
            $post = new Quote;
            $post
                ->setTitle($faker->catchPhrase)
                ->setContent($faker->markdown)
                ->setPosition($faker->randomElement(['none', 'important', null]))
                ->setCreatedAt($faker->dateTimeBetween('-2 years', 'now'))
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
