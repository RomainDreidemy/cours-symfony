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
        $quotes = $this->findAll();

        $htmlQuotes = [];
        foreach ($quotes as $quote){
            $htmlQuotes[] = [
                'title' => $quote->getTitle(),
                'content' => $this->parser->markdownToHtml($quote->getContent()),
                'position' => $quote->getPosition(),
                'createdAt' => $quote->getCreatedAt()
            ];
        }

        return $htmlQuotes;
    }

    public function findAll(): array
    {
        $qImportants = $this->quoteRepository->findByPosition('important');
        $qNone = $this->quoteRepository->findByPosition('none');
        $qNull = $this->quoteRepository->findByPosition(null);

        return array_merge($qImportants, $qNone, $qNull);
    }
}