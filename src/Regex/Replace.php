<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Regex;

abstract class Replace
{
    protected function removeHtmlTags($string)
    {
        return preg_replace('/(<script(\s|\S)*?<\/script>)|(<style(\s|\S)*?<\/style>)|(<!--(\s|\S)*?-->)|(<\/?(\s|\S)*?>)/', '', $string);
    }

    protected function removeCodeTags($string)
    {
        return preg_replace('/(<code(\s|\S)*?<\/code>)/', '', $string);
    }

    protected function removeLiveBreaks($string)
    {
        return preg_replace("/\r|\n/", "", $string);
    }
}
