<?php

namespace Sigmie\Crawler\Contracts;

use Symfony\Component\Panther\DomCrawler\Crawler;
use Facebook\WebDriver\WebDriverElement as Element;

interface Navigator
{
    public function visit(string $url);

    public function getCrawler(): Crawler;
}
