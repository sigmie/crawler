<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests\Commands;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Commands\Crawl;
use Sigmie\Crawler\Exports\JSON;
use Sigmie\Crawler\Format\Basic;
use Sigmie\Crawler\Spider;
use Symfony\Component\Console\Tester\CommandTester;

class CrawlTest extends TestCase
{
    /**
     * @var Spider|MockObject
     */
    private $spiderMock;

    /**
     * @var array
     */
    private array $config = [
        'start_url' => 'https://foo.com',
        'format' => 'basic',
        'export' => [
            'format' => 'json',
            'path' => '/tmp/test.content.json'
        ],
        'navigation_selector' => '.some-class',
        'content_selector' => '.some-content'
    ];

    private string $configPath = './test.config.json';

    public function setUp(): void
    {
        parent::setUp();

        file_put_contents($this->configPath, json_encode($this->config));

        $this->spiderMock = $this->createMock(Spider::class);
    }

    public function tearDown(): void
    {
        unlink($this->configPath);
    }

    /**
     * @test
     */
    public function command(): void
    {
        $tester = new CommandTester(new Crawl($this->spiderMock));

        $this->spiderMock->expects($this->once())->method('visit')->with('https://foo.com')->willReturnSelf();
        $this->spiderMock->expects($this->once())->method('navigateOver')->with('.some-class')->willReturnSelf();
        $this->spiderMock->expects($this->once())->method('extractContent')->with('.some-content')->willReturnSelf();
        $this->spiderMock->expects($this->once())->method('format')->with(new Basic)->willReturnSelf();
        $this->spiderMock->expects($this->once())->method('export')->with(new JSON('/tmp/test.content.json'))->willReturnSelf();

        $result = $tester->execute(['config' => $this->configPath]);

        $this->assertEquals(0, $result);
    }
}
