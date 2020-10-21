<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Navigator;
use Symfony\Component\BrowserKit\AbstractBrowser;

class NavigatorTest extends TestCase
{
    /**
     * @var Navigator
     */
    private $navigator;

    /**
     * @var AbstractBrowser|MockObject
     */
    private $browserMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->browserMock = $this->getMockBuilder(AbstractBrowser::class)
            ->addMethods(['close'])
            ->getMockForAbstractClass();

        $this->browserMock = $this->getMockForAbstractClass(
            AbstractBrowser::class,
            [],
            '',
            true,
            true,
            true,
            ['request', 'close'],
        );

        $this->navigator = new Navigator($this->browserMock);
    }

    /**
     * @test
     */
    public function current_url_is_correct(): void
    {
        $this->navigator->visit('https://foo.com');

        $this->assertEquals('https://foo.com', $this->navigator->getCurrentUrl());
    }

    public function page_is_requested()
    {
        $this->browserMock->expects($this->once())->method('request')->with('GET', 'https://google.com');

        $this->navigator->visit('https://google.com');
    }

    /**
     * @test
     */
    public function browser_is_closed_on_exception()
    {
        $this->expectException(Exception::class);

        $this->browserMock->method('request')->willThrowException(new Exception('Something went wrong!'));

        $this->browserMock->expects($this->once())->method('close');

        $this->navigator->visit('https://google.com');
    }
}
