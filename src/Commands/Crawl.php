<?php

declare(strict_types=1);

namespace Sigmie\Crawler\Commands;

use Exception;
use Sigmie\Crawler\Contracts\Export;
use Sigmie\Crawler\Contracts\Format;
use Sigmie\Crawler\Exports\JSON;
use Sigmie\Crawler\Format\Basic;
use Sigmie\Crawler\Spider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Crawl extends Command
{
    protected static $defaultName = 'sigmie:crawler:crawl ';

    protected Spider $spider;

    public function __construct(Spider $spider)
    {
        parent::__construct();

        $this->spider = $spider;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Crawl a webpage with the specified configs.');

        $this->addArgument('config', InputArgument::REQUIRED, 'Configuration file path.');
    }

    /**
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->readConfig($input->getArgument('config'));

        $this->spider->visit($config['start_url'])
            ->navigateOver($config['navigation_selector'])
            ->extractContent($config['content_selector'])
            ->format($this->pickFormat($config['format']))
            ->export($this->pickExport($config['export']));

        return Command::SUCCESS;
    }

    private function pickFormat(string $format): Format
    {
        if ($format === 'basic') {
            return new Basic();
        }

        throw new Exception("Formatter option {$format} not found.");
    }

    private function pickExport(array $export): Export
    {
        $formatName = $export['format'];

        if ($formatName === 'json') {
            return new JSON($export['path']);
        }

        throw new Exception("Formatter option {$formatName} not found.");
    }

    private function readConfig(string $path): array
    {
        $content = file_get_contents($path);

        return json_decode($content, true);
    }
}
