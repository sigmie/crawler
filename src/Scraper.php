<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Contracts\Exporter;
use Sigmie\Crawler\Contracts\Navigator;

class Scraper
{
    protected Navigator $navigator;

    protected Exporter $exporter;

    public function __construct(Navigator $navigator)
    {
        $this->navigator = $navigator;
    }
}
