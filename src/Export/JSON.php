<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Export;

use Sigmie\Crawler\Contracts\Exporter;

class JSON implements Exporter
{
    protected string $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        // create the file if needed
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }

        touch($this->filename);
    }

    public function exportPage($record)
    {
        // read the file if present
        $handle = fopen($this->filename, 'r+');

        if ($handle) {
            // seek to the end
            fseek($handle, 0, SEEK_END);

            // are we at the end of is the file empty
            if (ftell($handle) > 0) {
                // move back a byte
                fseek($handle, -1, SEEK_END);

                // add the trailing comma
                fwrite($handle, ',', 1);

                // add the new json string
                fwrite($handle, json_encode($record) . ']');
            } else {
                // write the first event inside an array
                fwrite($handle, json_encode(array($record)));
            }

            // close the handle on the file
            fclose($handle);
        }
    }
}
