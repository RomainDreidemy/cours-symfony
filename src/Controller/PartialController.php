<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartialController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Est la navigation du site internet.
     * @param string $routeName
     * @param string $category_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainMenu(string $routeName, string $category_id) {
        return $this->render('partials/menu.html.twig', [
            'categories' =>  $this->manager->getRepository(Category::class)->findByTerm('normal'),
            'routeName' => $routeName,
            'category_id' => $category_id
        ]);
    }
}
