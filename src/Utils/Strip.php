<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Utils;

abstract class Strip
{
    public function stripHtmlTags(string $string): string
    {
        return preg_replace(
            '/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)/',
            '',
            $string
        );
    }

    public function stripCodeTags(string $string): string
    {
        return preg_replace('/(<code(\s|\S)*?<\/code>)/', '', $string);
    }

    public function stripLineBreaks(string $string): string
    {
        return preg_replace("/\r|\n/", " ", $string);
    }

    public function stripLeadingAndTrailingSpaces(string $string): string
    {
        return trim($string);
    }

    public function strip(string $needle, string $string): string
    {
        return str_replace($needle, '', $string);
    }

    public function stripWhitespaces(string $string): string
    {
        return str_replace(' ', '', $string);
    }
}
