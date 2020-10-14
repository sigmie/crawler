<?php declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

use Symfony\Component\Panther\DomCrawler\Crawler;

interface Navigator
{
    public function visit(string $url);
}
