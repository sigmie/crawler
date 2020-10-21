<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverSearchContext;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Contracts\Export;
use Sigmie\Crawler\Contracts\Format;
use Sigmie\Crawler\Spider;
use Symfony\Component\BrowserKit\AbstractBrowser;

class SpiderTest extends TestCase
{
    /**
     * @var Format|MockObject
     */
    private $formatterMock;

    /**
     * @var Export|MockObject
     */
    private $exportMock;

    /**
     * @var AbstractBrowser|MockObject
     */
    private $browserMock;

    /**
     * @var WebDriverSearchContext|MockObject
     */
    private $searchContext;

    /**
     * @var WebDriverElement|MockObject
     */
    private $elementMock;

    /**
     * @var Spider
     */
    private $spider;

    public function setUp(): void
    {
        parent::setUp();

        $this->browserMock = $this->getMockForAbstractClass(
            AbstractBrowser::class,
            [],
            '',
            true,
            true,
            true,
            ['request', 'close', 'getCrawler'],
        );

        $this->elementMock = $this->createMock(WebDriverElement::class);
        $this->elementMock->method('findElements')->willReturn([$this->elementMock]);

        $this->searchContext = $this->createMock(WebDriverSearchContext::class);
        $this->searchContext->method('findElement')->willReturn($this->elementMock);

        $this->browserMock->method('getCrawler')->willReturn($this->searchContext);

        $this->formatterMock = $this->createMock(Format::class);
        $this->exportMock = $this->createMock(Export::class);

        $this->spider = new Spider($this->browserMock);
    }

    /**
     * @test
     */
    public function static_create()
    {
        $instance = Spider::create();

        $this->assertInstanceOf(Spider::class, $instance);
    }

    /**
     * @test
     */
    public function visit()
    {
        $this->browserMock->expects($this->once())->method('request')->with('GET', 'https://example.com');

        $this->spider->visit('https://example.com');
    }


    /**
     * @test
     */
    public function navigate_over()
    {
        $this->elementMock->method('getAttribute')->willReturn('https://example.com/sub-page');

        $byClass = WebDriverBy::cssSelector('.some-class');
        $byA = WebDriverBy::cssSelector('a');

        $this->searchContext->expects($this->once())->method('findElement')->with($byClass);
        $this->elementMock->expects($this->once())->method('findElements')->with($byA);
        $this->elementMock->expects($this->once())->method('getAttribute')->with('href');

        $this->spider->visit('https://example.com')->navigateOver('.some-class');
    }
}
