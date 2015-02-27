<?php

namespace MOG\Toggl\Command;

use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Output\OutputInterface;

class WorkspaceListCommand extends TogglCommand
{
    protected function configure()
    {
        $this
            ->setName('workspace:list')
            ->setDescription('List available workspaces')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Workspace list');
        $output->writeln('');

        $table = $this->getHelperSet()->get('table');

        $workspaces = $this->client->getWorkspaces();

        $content = array();
        foreach ($workspaces as $workspace) {
            $content[] = array($workspace['id'], $workspace['name']);
        }

        $table->setHeaders(array('Id', 'Name'))->setRows($content)->render($output);
    }
}
