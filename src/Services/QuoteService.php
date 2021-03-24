<?php


namespace App\Services;


use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuoteService
{
    private $quoteRepository;
    private $parser;
    private $manager;

    public function __construct(QuoteRepository $quoteRepository, HelperParser $parser, EntityManagerInterface $manager)
    {
        $this->quoteRepository = $quoteRepository;
        $this->parser = $parser;
        $this->manager = $manager;
    }

    public function getQuotesAsHtml()
    {
        $quotes = $this->findAll();

        $htmlQuotes = [];
        foreach ($quotes as $quote){
            $htmlQuotes[] = [
                'id' => $quote->getId(),
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

    public function delete(Quote $quote){
        $this->manager->remove($quote);
        $this->manager->flush();
    }
}