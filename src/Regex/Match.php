<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Regex;

abstract class Match extends Replace
{
    protected function findLevel($title)
    {
        preg_match('/h(?<level>[1-6])/', $title, $match);

        return (int) $match['level'];
    }

    protected function hasSameLevel($html, $level)
    {
        return str_contains($html, "h{$level}");
    }
}
