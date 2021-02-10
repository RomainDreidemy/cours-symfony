<?php

namespace App\Controller;

use App\Services\BeerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    private $beerService;

    public function __construct(BeerService $beerService)
    {
        $this->beerService = $beerService;
    }

    /**
     * @Route("/bar", name="bar")
     */
    public function index(): Response
    {
        return $this->render('bar/index.html.twig', [
            'title' => 'The Bar',
        ]);
    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render('bar/index.html.twig', [
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
}
