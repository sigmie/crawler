<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Content;

use Sigmie\Crawler\Contracts\ContentType;

class HTML implements ContentType
{
    protected string $html;

    public function __construct(string $html)
    {
        $this->html = $html;
    }

    public function __toString()
    {
        return $this->html;
    }
}
