<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests;

use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Utils\Extract;

class ExtractTest extends TestCase
{
    /**
     * @var Extract
     */
    private $extract;

    public function setUp(): void
    {
        parent::setUp();

        $this->extract = $this->getMockForAbstractClass(Extract::class);
    }

    /**
     * @test
     */
    public function extract_headings(): void
    {
        $extracted = $this->extract->extractHeadings('<h1>Foo</h1><p>Lorem ispum</p><h2>Bar</h2>');

        $this->assertEquals(['<h1>Foo</h1>', '<h2>Bar</h2>'], $extracted);
    }

    /**
     * @test
     */
    public function extract_heading_importance()
    {
        $extracted = $this->extract->extractHeadingImportance('<h6>Bar</h6>');

        $this->assertEquals(6, $extracted);
    }
}
