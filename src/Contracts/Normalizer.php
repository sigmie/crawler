<?php

namespace Sigmie\Crawler\Contracts;

interface Normalizer
{
    public function normalize(string $html);
}
