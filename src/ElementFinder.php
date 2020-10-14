<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement as Element;
use Sigmie\Crawler\Contracts\ElementFinder as ElementLocatorInterface;
use Symfony\Component\Panther\DomCrawler\Crawler;

class ElementFinder implements ElementLocatorInterface
{
    protected Crawler $crawler;

    public function __construct(Crawler &$crawler)
    {
        $this->crawler = $crawler;
    }

    public function findElement(string $selector): Element
    {
        $by = WebDriverBy::cssSelector($selector);

        return $this->crawler->findElement($by);
    }

    public function findChildElements(Element $element, string $selector): array
    {
        $by = WebDriverBy::cssSelector($selector);

        return $element->findElements($by);
    }
}
