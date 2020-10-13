<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Contracts\Normalizer;

class DefaultNormalizer implements Normalizer
{
    public function normalize(string $html)
    {
        preg_match_all("/(?<titles><(?<tag>(h1|h2|h3|h4|h5|h6).*?) ?[a-z-0-9\"=]*>(.*)<\/\g{tag}>)/U", $html, $titleHtmlMatch);

        $titles = $titleHtmlMatch['titles'];
        $contents = [];

        foreach ($titles as $index => $title) {

            if ($index === 0) {
                $html = str_replace($title, '', $html);
                continue;
            }

            [$content, $rest] = explode($title, $html);

            $contents[] = $content;

            if (!empty(trim($content))) {
                $html = str_replace($content, '', $html);
            }

            $html = str_replace($title, '', $html);
        }

        $contents[] = $rest;

        $res = array_combine($titles, $contents);

        $result = [];

        foreach ($res as $title => $content) {

            $level = $this->findLevel($title);

            $this->removeCodeTags($title);
            $this->removeCodeTags($content);

            $this->stripHtmlTags($title);
            $this->stripHtmlTags($content);

            $this->stripLineBreaks($content);
            $this->stripLineBreaks($title);

            $result[] = [
                'level' => $level,
                'title' => trim($title),
                'content' => trim($content),
            ];
        }

        return $result;
    }

    public function findLevel($title)
    {
        preg_match('/h(?<level>[1-6])/', $title, $match);

        return (int) $match['level'];
    }

    public function hasSameLevel($html, $level)
    {
        return str_contains($html, "h{$level}");
    }

    public function stripHtmlTags(&$html)
    {
        $html =  preg_replace('/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)/', '', $html);
    }

    public function removeCodeTags(&$html)
    {
        $html = preg_replace('/(<code(\s|\S)*?<\/code>)/', '', $html);
    }

    public function stripLineBreaks($string)
    {
        $string = preg_replace("/\r|\n/", "", $string);
    }
}
