<?php

namespace App\Controller;

use App\Entity\Beer;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Statistic;
use App\Services\BeerService;
use App\Services\CountryService;
use App\Services\Hello;
use App\Services\HelperParser;
use App\Services\StatisticService;
use cebe\markdown\Markdown;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    private $beerService;
    private $countryService;
    private $statisticService;
    private $manager;

    public function __construct(BeerService $beerService, CountryService $countryService, EntityManagerInterface $manager, StatisticService $statisticService)
    {
        $this->beerService = $beerService;
        $this->countryService = $countryService;
        $this->statisticService = $statisticService;
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
        $statisticManager = $this->manager->getRepository(Statistic::class);
        $clientManager = $this->manager->getRepository(Client::class);

        return $this->render('bar/index.html.twig', [
            'title' => 'The Bar',
            'countries' => $this->countryService->getAll(),
            'beers' => $this->manager->getRepository(Beer::class)->findLast(3),
            'clients' => $clientManager->findAll(),
            'statistiques' => [
                'averageBuy' => number_format($statisticManager->averageBuy(), 2),
                'averageAge' => number_format($clientManager->averageAge(),2),
                'clientHaveAlreadyByABeer' => $clientManager->haveAlreadyByABeer(),
                'score' => [
                    'average' => number_format($statisticManager->averageScore(), 2),
                    'highter' => $statisticManager->higterScore(),
                    'lower' => $statisticManager->lowerScore()
                ],
                'ecartType' => $this->statisticService->getEcartTypeForBeerClient(),
                'clientsOrderByCountBeer' => $clientManager->findAllOrderByCountBeer('desc')
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

    /**
     * @Route("/showService", name="showService")
     */
    public function showService(Hello $hello, HelperParser $helperParser): Response
    {
        $markdows = [
            'post' => <<<EOT
* Pommes
* Poires
    * Sous élément avec au moins quatre espaces devant.
EOT
        ];

        return $this->render('service/index.html.twig', [
            'title' => $hello->say(),
            'text' => $helperParser->markdownToHtml($markdows['post'])
        ]);
    }
}
