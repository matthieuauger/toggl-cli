<?php

namespace MOG\Toggl\Command;

use AJT\Toggl\TogglClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractTogglCommand extends Command
{
    protected $client;

    protected $config;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->config = Yaml::parse(__DIR__ . '/../../../../app/config/parameters.yml')['toggl'];
        $this->client = TogglClient::factory(array('api_key' => $this->config['api_key']));
    }
}
