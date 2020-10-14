<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Content\HTML;
use Sigmie\Crawler\Contracts\Formatter as FormatterInterface;
use Sigmie\Crawler\Regex\Regexer;

class Formatter extends Regexer implements FormatterInterface
{
    public function formatHTML(HTML $crawledData, string $url): array
    {
        $crawledData = $this->normalize($crawledData);

        $hits = [];

        foreach ($crawledData as $index => $data) {
            $level = $data['level'];
            $title = $data['title'];
            $content = $data['content'];

            $foo = [];
            $previousIndex = $index - 1;

            $foo[] = $title;
            $currentLevel = $level;

            while (isset($crawledData[$previousIndex])) {
                if ($crawledData[$previousIndex]['level'] < $currentLevel) {

                    $currentLevel = $crawledData[$previousIndex]['level'];

                    $foo[] = $crawledData[$previousIndex]['title'];
                }

                $previousIndex--;
            }

            $hits[] = [
                'content' => $content,
                'hierarchy' => $foo,
                'type' => 'content',
                'url' => $url
            ];
        }

        return $hits;
    }

    public function normalize(HTML $html)
    {
        $html = (string) $html;

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

            $title = $this->removeCodeTags($title);
            $content = $this->removeCodeTags($content);

            $title = $this->removeHtmlTags($title);
            $content = $this->removeHtmlTags($content);

            $title = $this->removeLiveBreaks($title);
            $content = $this->removeLiveBreaks($content);

            $result[] = [
                'level' => $level,
                'title' => trim($title),
                'content' => trim($content),
            ];
        }

        return $result;
    }
}
