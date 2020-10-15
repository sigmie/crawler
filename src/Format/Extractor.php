<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

abstract class Extractor extends Striper
{
    protected function extractHeadingImportance(string $title)
    {
        preg_match('/h(?<importance>[1-6])/', $title, $match);

        return (int) $match['importance'];
    }

    protected function extractHeadings(string $html)
    {
        preg_match_all("/(?<headings><(?<tag>(h[1-6]).*?) ?[a-z-0-9\"=]*>(.*)<\/\g{tag}>)/U", $html, $titleHtmlMatch);

        return $titleHtmlMatch['headings'];
    }

    protected function isEmptyString(string $string)
    {
        return empty($this->stripWhitespaces($string));
    }

    protected function isNotEmptyString(string $string)
    {
        return $this->isEmptyString($string)  === false;
    }
}
