<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Tests\Export;

use PHPUnit\Framework\TestCase;
use Sigmie\Crawler\Contracts\Exporter;
use Sigmie\Crawler\Export\JSON;

class JSONTest extends TestCase
{
    /**
     * @var string
     */
    private $filename = 'foo.json';

    /**
     * @var Exporter
     */
    private $exporter;

    public function setUp(): void
    {
        parent::setUp();

        $this->exporter = new JSON($this->filename);
    }

    /**
     * @test
     */
    public function export_file_is_created()
    {
        $this->assertFileExists($this->filename);
    }

    /**
     * @test
     */
    public function content_are_written()
    {
        $firstLine = ['foo' => 'bar'];
        $secondLine = ['foo' => 'baz'];

        $this->exporter->exportPage($firstLine);
        $this->exporter->exportPage($secondLine);

        $expectedJson = [
            ['foo' => 'bar'],
            ['foo' => 'baz'],
        ];

        $actualJson = json_decode(file_get_contents($this->filename), true);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function tearDown(): void
    {
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }
    }
}
