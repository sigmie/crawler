<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Contracts\Formatter;

class DefaultFormater implements Formatter
{
    public function __construct(string $currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public function formatScrappedResults($crawledData)
    {
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
                'url' => $this->currentUrl
            ];
        }

        return $hits;
    }
}
