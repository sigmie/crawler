<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests\Utils;

use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Utils\Strip;

class StripTest extends TestCase
{
    /**
     * @var Strip
     */
    private $strip;

    public function setUp(): void
    {
        parent::setUp();

        $this->strip = $this->getMockForAbstractClass(Strip::class);
    }

    /**
     * @test
     */
    public function strip_code_tags()
    {
        $stripped =  $this->strip->stripCodeTags('<code>foo</code>');

        $this->assertEmpty($stripped);
    }

    /**
     * @test
     */
    public function strip_line_breaks()
    {
        $striped = $this->strip->stripLineBreaks("foo bar");

        $this->assertEquals('foo bar', $striped);
    }

    /**
     * @test
     */
    public function strip_leading_and_trailing_spaces()
    {
        $striped = $this->strip->stripLeadingAndTrailingSpaces(' foo  ');

        $this->assertEquals('foo', $striped);
    }

    /**
     * @test
     */
    public function strip_needle()
    {
        $striped = $this->strip->strip('#', '#Some title');

        $this->assertEquals('Some title', $striped);
    }

    /**
     * @test
     */
    public function strip_white_spaces()
    {
        $striped = $this->strip->stripWhitespaces(' foo bar  baz');

        $this->assertEquals('foobarbaz', $striped);
    }

    /**
     * @test
     */
    public function strip_html_tags()
    {
        $striped = $this->strip->stripHtmlTags('<h1>Some title. </h1><p>And some body.</pw>');

        $this->assertEquals('Some title. And some body.', $striped);
    }
}
