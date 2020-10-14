<?php declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

use Facebook\WebDriver\WebDriverElement as Element;

interface ElementFinder
{
    public function findElement(string $class): Element;

    /**
     * @return Element[]
     */
    public function findChildElements(Element $element, string $tag): array;
}
