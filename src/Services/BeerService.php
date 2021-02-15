<?php
namespace App\Services;

use App\Entity\Beer;
use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BeerService
{
    private $client;
    private $manager;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $manager)
    {
        $this->client = $client;
        $this->manager = $manager;
    }

    public function getAll(): array
    {
        return $this->manager->getRepository(Beer::class)->findAll();
    }

    public function create(string $name, float $degree, \DateTime $publishedAt = null, string $description = null, float $price = null, array $categories = [], Country $country = null): Beer
    {
        $beer = (new Beer())
            ->setName($name)
            ->setPublishedAt($publishedAt)
            ->setDescription($description)
            ->setPrice($price)
            ->setDegree($degree)
        ;

        foreach ($categories as $category){
            $beer->addCategory($category);
        }

        if(!is_null($country)){
            $beer->setCountry($country);
        }

        $this->manager->persist($beer);
        $this->manager->flush();

        return $beer;
    }
}