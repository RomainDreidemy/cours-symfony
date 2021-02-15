<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Statistic;
use App\Services\BeerService;
use App\Services\CountryService;
use App\Services\StatisticService;
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
     * @Route("/", name="bar_redirect")
     */
    public function barRedirect(): Response{ return $this->redirectToRoute('bar'); }

    /**
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        $this->manager->getRepository(Statistic::class)->averageScore();

        $statisticManager = $this->manager->getRepository(Statistic::class);

        return $this->render('bar/index.html.twig', [
            'title' => 'The Bar',
            'countries' => $this->countryService->getAll(),
            'beers' => $this->manager->getRepository(Beer::class)->findLast(3),
            'clients' => $this->manager->getRepository(Client::class)->findAll(),
            'statistiques' => [
                'averageBuy' => number_format($statisticManager->averageBuy(), 2),
                'averageAge' => number_format($this->manager->getRepository(Client::class)->averageAge(),2),
                'clientHaveAlreadyByABeer' => $this->manager->getRepository(Client::class)->haveAlreadyByABeer(),
                'score' => [
                    'average' => number_format($statisticManager->averageScore(), 2),
                    'highter' => $statisticManager->higterScore(),
                    'lower' => $statisticManager->lowerScore()
                ]
            ]
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
            'title' => 'Bières ' . $category->getName(),
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
}
