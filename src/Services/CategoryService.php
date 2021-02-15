<?php
namespace App\Services;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function create(string $name, string $description = null, string $term = null): Category
    {
        $category = (new Category())
            ->setName($name)
            ->setDescription($description)
        ;

        if(!is_null($term)){
            $category->setTerm($term);
        }

        $this->manager->persist($category);
        $this->manager->flush();

        return $category;
    }
    public function getAll(): array
    {
        return $this->manager->getRepository(Category::class)->findAll();
    }
}