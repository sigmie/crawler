<?php declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

interface Exporter
{
    public function exportPage($data);
}
