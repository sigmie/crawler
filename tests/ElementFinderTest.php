<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverSearchContext;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\ElementFinder;
use Symfony\Component\DomCrawler\Crawler;

class ElementFinderTest extends TestCase
{
    /**
     * @var ElementFinder
     */
    private $elementFinder;

    /**
     * @var Crawler|MockObject
     */
    private $crawlerMock;

    /**
     * @var WebDriverSearchContext|MockObject
     */
    private $elementMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementMock = $this->createMock(WebDriverElement::class);
        $this->elementMock->method('findElements')->willReturn([]);

        $this->crawlerMock = $this->createMock(WebDriverSearchContext::class);
        $this->crawlerMock->method('findElement')->willReturn($this->elementMock);

        $this->elementFinder = new ElementFinder($this->crawlerMock);
    }

    /**
     * @test
     */
    public function find_element(): void
    {
        $by = WebDriverBy::cssSelector('.className');

        $this->crawlerMock->expects($this->once())->method('findElement')->with($by);

        $this->elementFinder->findElement('.className');
    }

    /**
     * @test
     */
    public function find_child_element()
    {
        $by = WebDriverBy::cssSelector('.className');

        $this->elementMock->expects($this->once())->method('findElements')->with($by);

        $this->elementFinder->findChildElements($this->elementMock, '.className');
    }
}
