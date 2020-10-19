<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

abstract class AbstractFormatter extends Extract
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
