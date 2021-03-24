<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    /**
     * @Route("/quote/new", name="quote_new")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(QuoteType::class, $quote = new Quote());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($quote);
            $manager->flush();

            return $this->redirectToRoute('quotes');
        }

        return $this->render('quote/index.html.twig', [
            'title' => 'Création d\'une citation',
            'form' => $form->createView()
        ]);
    }
}
