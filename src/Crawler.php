<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\Client as PantherClient;
use Throwable;

class Crawler
{
    protected PantherClient $client;

    protected Config $config;

    protected array $result = [];

    protected string $currentUrl;

    public function __construct(Config $config)
    {
        $this->client = \Symfony\Component\Panther\Client::createChromeClient();
        $this->config = $config;
    }

    public function crawl()
    {
        $result = [];

        foreach ($links as $link) {

            $this->currentUrl = $link;

            $html = $this->contentHtml($link);

            $levels = $this->extractContents($html);

            $result[] = $levels;
        }

        file_put_contents('export.json', json_encode($result));

        return;
    }

}
