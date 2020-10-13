<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Facebook\WebDriver\WebDriverBy;
use Sigmie\Crawler\Contracts\ElementLocator as ElementLocatorInterface;
use Facebook\WebDriver\WebDriverElement as Element;
use Symfony\Component\Panther\DomCrawler\Crawler;

class ElementLocator implements ElementLocatorInterface
{
    protected Crawler $crawler;

    public function __construct(Crawler &$crawler)
    {
        $this->crawler = $crawler;
    }

    public function findElementByClass(string $class): Element
    {
        $by = WebDriverBy::className($class);

        return $this->crawler->findElement($by);
    }

    public function findChildElementsByTag(Element $element, string $tag): array
    {
        $by = WebDriverBy::tagName($tag);

        return $element->findElements($by);
    }
}
