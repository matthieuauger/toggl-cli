<?php

namespace MOG\Toggl\Command;

use GuzzleHttp\Exception\ClientException;
use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TimeEntryPostCommand extends TogglCommand
{
    protected function configure()
    {
        $this
            ->setName('time-entry:create')
            ->setDescription('Create a new time entry')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating new time entry...');
        $output->writeln('');

        throw new \RuntimeException('Not implemented yet');

        $start = new \DateTime('2015-03-01 09:30:00');

        try {
            $this->client->startTimeEntry(
                array(
                    'pid' => 8592595,
                    'start' => $start,
                    'duration' => 3 * 60 * 60,
                    'description' => 'Accompagnement',
                )
            );
        } catch (ClientException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getResponse()->getBody()));
        }
    }
}
