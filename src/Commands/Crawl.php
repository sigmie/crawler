<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Commands;

use Exception;
use Sigmie\Crawler\Exports\JSON;
use Sigmie\Crawler\Format\Basic;
use Sigmie\Crawler\Spider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Crawl extends Command
{
    protected static $defaultName = 'sigmie:crawler:crawl ';

    protected function configure()
    {
        $this->setDescription('Crawl a webpage with the specified configs.');

        $this->addArgument('config', InputArgument::REQUIRED, 'Configuration file path.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->readConfig($input->getArgument('config'));

        $spider = Spider::create();

        $spider->visit($config['start_url'])
            ->navigateOver($config['navigation_selector'])
            ->extractContent($config['content_selector'])
            ->format($this->pickFormat($config['format']))
            ->export($this->pickExport($config['export']));

        return Command::SUCCESS;
    }

    private function pickFormat($format)
    {
        if ($format === 'basic') {
            return new Basic;
        }

        throw new Exception("Formatter option {$format} not found.");
    }

    private function pickExport(array $export)
    {
        $formatName = $export['format'];

        if ($formatName === 'json') {
            return new JSON($export['path']);
        }

        throw new Exception("Formatter option {$formatName} not found.");
    }

    private function readConfig(string $path)
    {
        $content = file_get_contents($path);

        return json_decode($content, true);
    }
}
