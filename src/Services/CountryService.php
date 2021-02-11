<?php
namespace App\Services;

use App\Entity\Category;
use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;

class CountryService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function create(string $name, string $adresse, string $email): Country
    {
        $country = (new Country())
            ->setName($name)
            ->setAdresse($adresse)
            ->setEmail($email)
        ;

        $this->manager->persist($country);
        $this->manager->flush();

        return $country;
    }

    public function getAll(): array
    {
        return $this->manager->getRepository(Country::class)->findAll();
    }
}