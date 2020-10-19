<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

abstract class Extract extends Strip
{
    public function extractHeadingImportance(string $title): int
    {
        preg_match('/h(?<importance>[1-6])/', $title, $match);

        return (int) $match['importance'];
    }

    public function extractHeadings(string $html): array
    {
        preg_match_all("/(?<headings><(?<tag>(h[1-6]).*?) ?[a-z-0-9\"=]*>(.*)<\/\g{tag}>)/U", $html, $titleHtmlMatch);

        return $titleHtmlMatch['headings'];
    }
}
