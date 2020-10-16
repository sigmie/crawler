<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Generator;
use Sigmie\Crawler\Contracts\Exporter;
use Sigmie\Crawler\Contracts\Formatter;
use Symfony\Component\Panther\Client as Browser;

class Spider extends Navigator
{
    protected ElementFinder $locator;

    protected string $contentSelector;

    protected Formatter $formatter;

    protected Exporter $exporter;

    public static function create(): Spider
    {
        $browser = Browser::createChromeClient();

        return new static($browser);
    }

    public function navigateOver(string $class): self
    {
        $navigationElement = $this->locator->findElement($class);

        $aElements = $this->locator->findChildElements($navigationElement, 'a');

        $this->links = array_map(fn ($element) => $element->getAttribute('href'), $aElements);

        return $this;
    }

    public function extractContent(string $class): self
    {
        $this->contentSelector = $class;

        return $this;
    }

    public function format(Formatter $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function formattedPages(): Generator
    {
        foreach ($this->links as $link) {

            $this->visit($link);

            $element = $this->locator->findElement($this->contentSelector);

            $html = $element->getAttribute('innerHTML');

            yield $this->formatter->formatHTML($html, $this->currentUrl);
        }
    }

    public function export(Exporter $exporter): void
    {
        $this->exporter = $exporter;

        foreach ($this->formattedPages() as $pageData) {
            $this->exporter->exportPage($pageData);
        }
    }

    public function visit(string $uri): self
    {
        parent::visit($uri);

        $this->locator = new ElementFinder($this->browser->getCrawler());

        return $this;
    }
}
