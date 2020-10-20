<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Format;

use Sigmie\Crawler\Contracts\Formatter as FormatterInterface;
use Sigmie\Crawler\Format\AbstractFormat;

class Basic extends AbstractFormat implements FormatterInterface
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

    protected function createHierarchy(array $headings): array
    {
        $reversed = array_reverse($headings);

        $result = [];

        foreach ($reversed as $index => $heading) {
            $level = $index + 1;
            $result[$level] = $heading;
        }

        return $result;
    }

    protected function formatTitle(string $title): string
    {
        $title = $this->stripCodeTags($title);
        $title = $this->stripHtmlTags($title);
        $title = $this->stripLineBreaks($title);
        $title = $this->strip('#', $title);

        return $this->stripLeadingAndTrailingSpaces($title);
    }

    protected function formatContent(string $content): string
    {
        $content = $this->stripCodeTags($content);
        $content = $this->stripHtmlTags($content);
        $content = $this->stripLineBreaks($content);
        return $this->stripLeadingAndTrailingSpaces($content);
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

    protected function extractHeadingContents(array $htmlHeadings, string $html): array
    {
        $contents = [];
        $rest = null;

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

    private function arrayHasIndex(array $array, int $index): bool
    {
        return isset($array[$index]);
    }
}
