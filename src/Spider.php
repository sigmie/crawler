<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Generator;
use Sigmie\Crawler\Contracts\Export;
use Sigmie\Crawler\Contracts\Format;
use Symfony\Component\Panther\Client as Browser;

class Spider extends Navigator
{
    protected ElementFinder $locator;

    protected string $contentSelector;

    protected Format $formatter;

    protected Export $exporter;

    /**
     * @var string[]
     */
    protected array $links;

    public static function create(): Spider
    {
        $browser = Browser::createChromeClient();

        return new self($browser);
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

    public function format(Format $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function export(Export $exporter): void
    {
        $this->exporter = $exporter;

        foreach ($this->formattedPages() as $pageData) {
            foreach ($pageData as $doc) {
                $this->exporter->exportPage($doc);
            }
        }
    }

    public function visit(string $uri): self
    {
        parent::visit($uri);

        $this->locator = new ElementFinder($this->browser->getCrawler());

        return $this;
    }

    /**
     * @return Generator|array[]
     */
    protected function formattedPages(): Generator
    {
        foreach ($this->links as $link) {
            $this->visit($link);

            $element = $this->locator->findElement($this->contentSelector);

            $html = $element->getAttribute('innerHTML');

            yield $this->formatter->formatHTML($html, $this->currentUrl);
        }
    }
}
