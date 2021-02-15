<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Country;
use App\Services\BeerService;
use App\Services\CountryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    private $beerService;
    private $countryService;
    private $manager;

    public function __construct(BeerService $beerService, CountryService $countryService, EntityManagerInterface $manager)
    {
        $this->beerService = $beerService;
        $this->countryService = $countryService;
        $this->manager = $manager;
    }

    /**
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        return $this->render('bar/index.html.twig', [
            'title' => 'The Bar',
            'countries' => $this->countryService->getAll(),
            'beers' => $this->manager->getRepository(Beer::class)->findLast(3)
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render('mentions/index.html.twig', [
            'title' => 'Mentions légales',
        ]);
    }

    /**
     * @Route("/beers", name="beers")
     */
    public function beers(): Response
    {
        return $this->render('bears/index.html.twig', [
            'title' => 'Bières',
            'beers' => $this->beerService->getAll()
        ]);
    }

    /**
     * @Route("/newbeer", name="create_beer")
     */
//    public function createBeer(): Response
//    {
//        $beer = $this->beerService->create();
//
//        return new Response('Saved new beer with id ' . $beer->getId());
//    }

    /**
     * @Route("/country/{id}", name="country_beer")
     */
    public function beerByCountry(Country $country): Response
    {
        return $this->render('bears/index.html.twig', [
            'title' => $country->getName(),
            'beers' => $country->getBeer()
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_beer")
     */
    public function beerByCategory(Category $category): Response
    {
        return $this->render('bears/index.html.twig', [
            'title' => $category->getName(),
            'beers' => $category->getBeer()
        ]);
    }

    /**
     * @Route("/beer/{id}", name="beer")
     */
    public function show(Beer $beer): Response
    {
        return $this->render('beer/beer.html.twig', [
            'title' => $beer->getName(),
            'beer' => $beer
        ]);
    }

    public function mainMenu() {
        return $this->render('partials/menu.html.twig', [ 'categories' =>  $this->manager->getRepository(Category::class)->findByTerm('normal')]);
    }




}
