<?php


namespace App\Services;


use App\Repository\QuoteRepository;

class QuoteService
{
    private $quoteRepository;
    private $parser;
    public function __construct(QuoteRepository $quoteRepository, HelperParser $parser)
    {
        $this->quoteRepository = $quoteRepository;
        $this->parser = $parser;
    }

    public function getQuotesAsHtml()
    {
        $quotes = $this->quoteRepository->findAll();

        $htmlQuotes = [];
        foreach ($quotes as $quote){
            $htmlQuotes[] = [
                'title' => $quote->getTitle(),
                'content' => $this->parser->markdownToHtml($quote->getContent())
            ];
        }

        return $htmlQuotes;
    }
}