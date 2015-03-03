<?php

namespace MOG\Toggl\Command;

use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ClientListCommand extends TogglCommand
{
    private $workspace;

    protected function configure()
    {
        $this
            ->setName('client:list')
            ->setDescription('List available clients')
            ->addArgument(
                'workspace',
                InputArgument::OPTIONAL,
                'The workspace identifer'
            )
            ->addOption(
                'filter',
                null,
                InputOption::VALUE_REQUIRED,
                'Filter by name'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        if (null !== $input->getArgument('workspace')) {
            $this->workspace = $input->getArgument('workspace');
        } else {
            $this->workspace = $this->config['workspace'];
        }

        if (null === $this->workspace) {
            throw new \Exception('No workspace found : You must either give a workspace to the command or configure one in the app/config/parameters.yml file');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Client list');
        $output->writeln('');

        $clients = $this->getClients($this->workspace);

        $filter = $input->getOption('filter');
        if (null !== $filter) {
            $clients = $this->filterClients($clients, $filter);
        }

        $this->displayClients($output, $clients, $filter);
    }

    private function getClients($workspaceId)
    {
        $clients = $this->client->getWorkspaceClients(
            array(
                'wid' => $workspaceId,
            )
        );

        uasort($clients, function($a, $b) {
            return $a['id'] < $b['id'];
        });

        return $clients;
    }

    private function filterClients(array $clients, $filter)
    {
        $clients = array_filter($clients, function($client) use ($filter) {
            return false !== stripos($client['name'], $filter);
        });

        return $clients;
    }

    private function displayClients(OutputInterface $output, $clients, $filter)
    {
        $table = $this->getHelperSet()->get('table');

        $content = array();
        foreach ($clients as $client) {
            $content[] = array($client['id'], $client['name']);
        }

        $table->setHeaders(array('Id', 'Name'))->setRows($content)->render($output);
    }
}
