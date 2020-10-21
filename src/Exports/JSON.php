<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Exports;

use Sigmie\Crawler\Contracts\Export;

class JSON implements Export
{
    /**
     * File name
     */
    protected string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (file_exists($this->filename)) {
            unlink($this->filename);
        }

        touch($this->filename);
    }

    /**
     * Write new record to json
     */
    public function exportPage(array $record): void
    {
        $handle = fopen($this->filename, 'r+');

        if ($handle) {
            fseek($handle, 0, SEEK_END);

            if (ftell($handle) > 0) {
                fseek($handle, -1, SEEK_END);

                fwrite($handle, ',', 1);

                fwrite($handle, json_encode($record) . ']');
            } else {
                fwrite($handle, json_encode(array($record)));
            }

            fclose($handle);
        }
    }
}
