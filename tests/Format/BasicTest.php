<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests\Format;

use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Contracts\Formatter;
use Sigmie\Crawler\Format\Basic;

class BasicTest extends TestCase
{
    /**
     * @var string
     */
    private $html = "<h1>Some title</h1>
                     <p>Some text</p>
                     <h2>Some other title</h2>
                     <p>Some other text</p>";

    /**
     * @var Formatter
     */
    private $format;

    public function setUp(): void
    {
        parent::setUp();

        $this->format = new Basic;
    }

    /**
     * @test
     */
    public function format(): void
    {
        $result = $this->format->formatHTML($this->html, 'https://example.com');

        $expected = [
            [
                'content' => 'Some text',
                'hierarchy' => [
                    1 => 'Some title'
                ],
                'url' => 'https://example.com'
            ],
            [
                'content' => 'Some other text',
                'hierarchy' => [
                    1 => 'Some title',
                    2 => 'Some other title'
                ],
                'url' => 'https://example.com'
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
