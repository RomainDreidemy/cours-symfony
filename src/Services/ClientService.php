<?php


namespace App\Services;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class ClientService
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function create(string $name, string $email, float $weight, int $age)
    {
        if($age < 18){
            return false;
        }

        $client = (new Client())
            ->setName($name)
            ->setEmail($email)
            ->setWeight($weight)
            ->setAge($age)
        ;

        $this->manager->persist($client);
        $this->manager->flush();

        return $client;
    }
}