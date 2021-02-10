<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BeerService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAll(): Array
    {
        $response = $this->client->request(
            'GET',
            'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json'
        );

        $statusCode = $response->getStatusCode();

        $contentType = $response->getHeaders()['content-type'][0];

        $content = $response->getContent();

        $content = $response->toArray();

        return $content['beers'];
    }
}