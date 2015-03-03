<?php

namespace MOG\Toggl\Command;

use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectListCommand extends TogglCommand
{
    private $workspace;

    protected function configure()
    {
        $this
            ->setName('project:list')
            ->setDescription('List available projects')
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
        $output->writeln('Project list');
        $output->writeln('');

        $projects = $this->getProjects($this->workspace);

        $filter = $input->getOption('filter');
        if (null !== $filter) {
            $projects = $this->filterProjects($projects, $filter);
        }

        $this->displayProjects($output, $projects, $filter);
    }

    private function getProjects($workspaceId)
    {
        $projects = $this->client->getWorkspaceProjects(
            array(
                'wid' => $workspaceId,
            )
        );

        uasort($projects, function($a, $b) {
            return $a['id'] < $b['id'];
        });

        return $projects;
    }

    private function filterProjects(array $projects, $filter)
    {
        $projects = array_filter($projects, function($project) use ($filter) {
            return false !== stripos($project['name'], $filter);
        });

        return $projects;
    }

    private function displayProjects(OutputInterface $output, $projects, $filter)
    {
        $table = $this->getHelperSet()->get('table');

        $content = array();
        foreach ($projects as $project) {
            $content[] = array($project['id'], $project['name']);
        }

        $table->setHeaders(array('Id', 'Name'))->setRows($content)->render($output);
    }
}
