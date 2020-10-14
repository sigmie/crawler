<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

use Sigmie\Crawler\Content\HTML;

interface Formatter
{
    public function formatHTML(HTML $html, string $url): array;
}
