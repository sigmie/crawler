<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Contracts;

interface Navigator
{
    public function visit(string $url): self;
}
