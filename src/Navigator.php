<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

use Sigmie\Crawler\Contracts\Navigator as NavigatorInterface;
use Symfony\Component\Panther\Client as Browser;
use Throwable;

class Navigator implements NavigatorInterface
{
    /**
     * @var Browser
     */
    protected $browser;

    protected string $currentUrl;

    /**
     * @param Browser $browser
     */
    public function __construct($browser)
    {
        $this->browser = $browser;
    }

    public function visit(string $url): self
    {
        $this->currentUrl = $url;

        try {
            $this->browser->request('GET', $url);
        } catch (Throwable $throwable) {
            $this->browser->close();

            throw $throwable;
        }

        return $this;
    }

    public function getCurrentUrl(): string
    {
        return $this->currentUrl;
    }
}
