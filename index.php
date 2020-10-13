<?php

use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;
use PhpParser\Node\Expr\Throw_;
use Sigmie\Crawler\Config;
use Sigmie\Crawler\Crawler;
use Sigmie\Crawler\ElementLocator;
use Sigmie\Crawler\Spider;
use Symfony\Component\Panther\DomCrawler\Link;

require __DIR__ . '/vendor/autoload.php'; // Composer's autoloader

$configuration = new Config;
$configuration->setUrl('https://docs.sigmie.com');

$configuration->setIgnoreList([
    "https://github.com/sigmie",
    "https://app.sigmie.com/",
    "https://docs.sigmie.com/"
]);
$configuration->setNavigationSelector('sidebar-links');
$configuration->setContentSelector('content__default');

// $configuration->setUrl('https://laravel.com/docs/8.x/upgrade');
// $configuration->setNavigationSelector('docs_sidebar');
// $configuration->setContentSelector('docs_body');

$spider = Spider::create();

$spider->visit('https://docs.sigmie.com')
    ->navigateOver('sidebar-links')
    ->scrape('content__default');
