<?php

namespace App\Http\Controllers\v1;

use App\Services\ParserServiceInterface;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParseImageController
{
    private ParserServiceInterface $parser;

    public function __construct(ParserServiceInterface $parser)
    {
        $this->parser = $parser;
    }

    public function handle(Request $request): Response
    {
        $requestArray = $request->toArray();
        $parseLink = $requestArray['url'] ?? '';

        if(!$this->validateUrl($parseLink)) {
            return new JsonResponse([
                'message' => 'Неправильная ссылка',
            ]);
        }

        $client = new Client();
        $response = $client->request('GET', $parseLink);

        $crawler = new Crawler((string) $response->getBody());

        $result = $this->parser->parse($crawler);

        return new JsonResponse([
            'message' => 'Изображений загружено - ' . $result,
        ]);
    }

    private function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}