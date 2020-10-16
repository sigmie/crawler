<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

abstract class Striper
{
    protected function stripHtmlTags(string $string): string
    {
        return preg_replace(
            '/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)/',
            '',
            $string
        );
    }

    protected function stripCodeTags(string $string): string
    {
        return preg_replace('/(<code(\s|\S)*?<\/code>)/', '', $string);
    }

    protected function stripLineBreaks(string $string): string
    {
        return preg_replace("/\r|\n/", "", $string);
    }

    protected function stripLeadingAndTrailingSpaces(string $string): string
    {
        return trim($string);
    }

    protected function strip(string $needle, string $string): string
    {
        return str_replace($needle, '', $string);
    }

    protected function stripWhitespaces(string $string): string
    {
        return str_replace(' ', '', $string);
    }
}
