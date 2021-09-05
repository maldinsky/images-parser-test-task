<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

interface ParserServiceInterface
{
    public function parse(Crawler $crawler);
}