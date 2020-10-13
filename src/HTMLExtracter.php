<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Facebook\WebDriver\WebDriverElement as Element;

class HTMLExtracter
{
    public function elementAttribute(Element $element, string $attribute)
    {
        return $element->getAttribute($attribute);
    }

    public function elementsAttribute(array $elements, string $attribute)
    {
        $result = [];

        foreach ($elements as $element) {
            $result[] = $this->elementAttribute($element, $attribute);
        }

        return $result;
    }

    public function elementHTML(Element $element)
    {
        return $element->getAttribute('innerHTML');
    }
}
