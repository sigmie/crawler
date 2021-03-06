<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests\Format;

use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Format\AbstractFormat;

class AbstractFormatterTest extends TestCase
{
    /**
     * @var AbstractFormat
     */
    private $formatter;

    public function setUp(): void
    {
        parent::setUp();

        $this->formatter = $this->getMockForAbstractClass(AbstractFormat::class);
    }

    /**
     * @test
     */
    public function is_empty_string()
    {
        $isEmpty = $this->formatter->isEmptyString('  ');

        $this->assertTrue($isEmpty);

        $isEmpty = $this->formatter->isEmptyString(' hmm.. ');

        $this->assertFalse($isEmpty);
    }

    /**
     * @test
     */
    public function is_not_empty_string()
    {
        $isEmpty = $this->formatter->isNotEmptyString('  ');

        $this->assertFalse($isEmpty);

        $isEmpty = $this->formatter->isNotEmptyString(' hmm.. ');

        $this->assertTrue($isEmpty);
    }
}
