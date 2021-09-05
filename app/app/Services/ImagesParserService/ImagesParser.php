<?php

namespace App\Services\ImagesParserService;

use App\Services\ParserServiceInterface;
use App\Services\SaveImageServiceInterface;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ImagesParser implements ParserServiceInterface
{
    private Client $client;
    private SaveImageServiceInterface $saveImageService;

    public function __construct(Client $client, SaveImageServiceInterface $saveImageService)
    {
        $this->client = $client;
        $this->saveImageService = $saveImageService;
    }

    public function parse(Crawler $crawler): int
    {
        $images = $crawler->filter('img');
        $countImages = 0;

        $images->each(function (Crawler $nodeImage) use (&$countImages) {
            $imageLink = $nodeImage->attr('src') ?? $nodeImage->attr('data-src');

            if(!$this->validateImageLink($imageLink)) {
                return;
            }

            $imageName = $this->getImageName($imageLink);

            $this->client->request('GET', $imageLink, [
                'sink' => $this->saveImageService->save($imageName),
            ]);

            $countImages++;
        });

        return $countImages;
    }

    private function getImageName(string $imageLink): string
    {
        $names = explode('/', $imageLink);
        return $names[array_key_last($names)];
    }

    /*
     * @TODO Реализовать обработку относительных ссылок + рекурсию на валидацию
     */
    private function validateImageLink(string $imageLink): bool
    {
        return filter_var($imageLink, FILTER_VALIDATE_URL);
    }
}