<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

use Sigmie\Crawler\Utils\Extract;

abstract class AbstractFormat extends Extract
{
    public function isEmptyString(string $string): bool
    {
        return empty($this->stripWhitespaces($string));
    }

    public function isNotEmptyString(string $string): bool
    {
        return $this->isEmptyString($string)  === false;
    }
}
