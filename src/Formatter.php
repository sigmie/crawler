<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Contracts\Formatter as FormatterInterface;
use Sigmie\Crawler\Format\AbstractFormatter;

class Formatter extends AbstractFormatter implements FormatterInterface
{
    public function formatHTML(string $html, string $url): array
    {
        $titleLevelContents = $this->contentLevelTitleArray($html);

        $pageRecords = [];

        foreach ($titleLevelContents as $index => $data) {
            $level = $data['level'];
            $title = $data['title'];
            $content = $data['content'];
            $previousIndex = $index - 1;
            $headings = [];

            $headings[] = $title;
            $currentTitleLevel = $level;

            while ($this->arrayHasIndex($titleLevelContents, $previousIndex)) {

                $previousData = $titleLevelContents[$previousIndex];
                $previousLevel = $previousData['level'];
                $previousTitle = $previousData['title'];

                if ($previousLevel < $currentTitleLevel) {
                    $headings[] = $previousTitle;
                    $currentTitleLevel = $previousLevel;
                }

                $previousIndex--;
            }

            $hierarchy = $this->createHierarchy($headings);

            $pageRecords[] = [
                'content' => $content,
                'hierarchy' => $hierarchy,
                'type' => 'content',
                'url' => $url
            ];
        }

        return $pageRecords;
    }

    protected function createHierarchy(array $headings)
    {
        $reversed = array_reverse($headings);

        return array_map(fn ($value, $index) => [$index + 1 => $value], $reversed, array_keys($reversed));
    }

    private function arrayHasIndex($array, $index): bool
    {
        return isset($array[$index]);
    }

    protected function formatTitle(string $title): string
    {
        $title = $this->stripCodeTags($title);
        $title = $this->stripHtmlTags($title);
        $title = $this->stripLineBreaks($title);
        $title = $this->strip('#', $title);
        $title = $this->stripLeadingAndTrailingSpaces($title);

        return $title;
    }

    protected function formatContent(string $content): string
    {
        $content = $this->stripCodeTags($content);
        $content = $this->stripHtmlTags($content);
        $content = $this->stripLineBreaks($content);
        $content = $this->stripLeadingAndTrailingSpaces($content);

        return $content;
    }

    protected function contentLevelTitleArray(string $html): array
    {
        $htmlHeadings = $this->extractHeadings($html);

        $contents = $this->extractHeadingContents($htmlHeadings, $html);

        $res = array_combine($htmlHeadings, $contents);

        $result = [];

        foreach ($res as $title => $content) {

            $level = $this->extractHeadingImportance($title);
            $title = $this->formatTitle($title);
            $content = $this->formatContent($content);

            $result[] = [
                'level' => $level,
                'title' => $title,
                'content' => $content,
            ];
        }

        return $result;
    }

    protected function extractHeadingContents($htmlHeadings, $html)
    {
        $contents = [];

        foreach ($htmlHeadings as $index => $title) {

            if ($index === 0) {
                $html = $this->strip($title, $html);
                $rest = $html;

                continue;
            }

            [$content, $rest] = explode($title, $html);

            $contents[] = $content;

            if ($this->isNotEmptyString($content)) {
                $html = $this->strip($content, $html);
            }

            $html = $this->strip($title, $html);
        }

        $contents[] = $rest;

        return $contents;
    }
}
