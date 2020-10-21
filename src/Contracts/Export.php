<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

interface Export
{
    public function exportPage(array $data): void;
}
