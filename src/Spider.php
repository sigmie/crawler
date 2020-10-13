<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Navigator;
use Symfony\Component\Panther\Client as Browser;
use Throwable;
use Facebook\WebDriver\WebDriverElement as Element;
use Normalizer;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;
use PHPUnit\Util\TestDox\HtmlResultPrinter;

class Spider
{
    protected Config $config;

    protected Scraper $scraper;

    protected Navigator $navigator;

    protected ElementLocator $locator;

    protected HTMLExtracter $htmlExtracter;

    protected array $links = [];

    public function __construct()
    {
        $this->navigator = new Navigator(Browser::createChromeClient());
        $this->scraper = new Scraper($this->navigator);
        $this->htmlExtracter = new HTMLExtracter();
    }

    public static function create()
    {
        return new static();
    }

    public function navigateOver(string $class)
    {
        $navElement = $this->locator->findElementByClass($class);

        $aElements = $this->locator->findChildElementsByTag($navElement, 'a');

        $this->links = $this->htmlExtracter->elementsAttribute($aElements, 'href');

        return $this;
    }

    public function scrape(string $class)
    {
        foreach ($this->links as $link) {

            $this->visit($link);

            $element = $this->locator->findElementByClass($class);

            $html = $this->htmlExtracter->elementHTML($element);

            $normalized = (new DefaultNormalizer)->normalize($html);

            $formated = (new DefaultFormater($this->navigator->getCurrentUrl()))->formatScrappedResults($normalized);

            dd($formated);
        }
    }

    public function visit(string $uri)
    {
        $this->navigator->visit($uri);

        $this->locator = new ElementLocator($this->navigator->getCrawler());

        return $this;
    }
}
