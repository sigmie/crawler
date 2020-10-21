<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement as Element;
use Facebook\WebDriver\WebDriverSearchContext;
use Sigmie\Crawler\Contracts\ElementFinder as ElementLocatorInterface;

class ElementFinder implements ElementLocatorInterface
{
    protected WebDriverSearchContext $webdriver;

    public function __construct(WebDriverSearchContext $crawler)
    {
        $this->webdriver = $crawler;
    }

    public function findElement(string $selector): Element
    {
        $by = WebDriverBy::cssSelector($selector);

        return $this->webdriver->findElement($by);
    }

    public function findChildElements(Element $element, string $selector): array
    {
        $by = WebDriverBy::cssSelector($selector);

        return $element->findElements($by);
    }
}
