<?php

namespace Sigmie\Crawler\Contracts;

use Facebook\WebDriver\WebDriverElement as Element;

interface ElementLocator
{
    public function findElementByClass(string $class): Element;

    /**
     * @return Element[]
     */
    public function findChildElementsByTag(Element $element, string $tag): array;
}
