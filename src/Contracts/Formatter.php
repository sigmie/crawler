<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

interface Formatter
{
    public function formatHTML(string $html, string $url): array;
}
