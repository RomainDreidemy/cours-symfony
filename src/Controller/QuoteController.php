<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Services\QuoteService;
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

    /**
     * @Route("/quote/edit/{id}", name="quote_edit")
     */
    public function edit(Quote $quote,Request $request): Response
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($quote);
            $manager->flush();

            return $this->redirectToRoute('quotes');
        }

        return $this->render('quote/index.html.twig', [
            'title' => 'Édition d\'une citation',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/quote/delete/{id}", name="quote_delete", methods={"POST"})
     */
    public function delete(Quote $quote, QuoteService $quoteService): Response
    {
        $quoteService->delete($quote);
        $this->addFlash('success', 'La citation a été supprimé.');

        return $this->redirectToRoute('quotes');
    }
}
