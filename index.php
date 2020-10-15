<?php

use Sigmie\Crawler\Formatter;
use Sigmie\Crawler\Export\JSON;
use Sigmie\Crawler\Spider;

require __DIR__ . '/vendor/autoload.php'; // Composer's autoloader

$spider = Spider::create();

$spider->visit('https://docs.sigmie.com')
    ->navigateOver('.sidebar-links')
    ->extractContent('.content__default')
    ->format(new Formatter)
    ->export(new JSON('foo.json'));
