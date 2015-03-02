<?php

namespace MOG\Toggl\Command;

use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Output\OutputInterface;

class TimeEntryListCommand extends TogglCommand
{
    protected function configure()
    {
        $this
            ->setName('time-entry:list')
            ->setDescription('List time entries for current month')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Time entry list');
        $output->writeln('');

        $timeEntries = $this->getTimeEntries();
        $this->displayTimeEntries($output, $timeEntries);
    }

    private function getTimeEntries()
    {
        $startDate = new \DateTime('1 month ago');
        $endDate = new \DateTime();

        $timeEntries = $this->client->getTimeEntries(
            array(
                'start_date' => $startDate,
                'end_date' => $endDate,
            )
        );

        return array_reverse($timeEntries);
    }

    private function displayTimeEntries(OutputInterface $output, $timeEntries)
    {
        $table = $this->getHelperSet()->get('table');

        $content = array();
        foreach ($timeEntries as $timeEntry) {
            $startDate = \DateTime::createFromFormat(\DateTime::ISO8601, $timeEntry['start']);
            $startDate->setTimezone(new \DateTimeZone(date_default_timezone_get()));

            $stopDate = \DateTime::createFromFormat(\DateTime::ISO8601, $timeEntry['stop']);
            $stopDate->setTimezone(new \DateTimeZone(date_default_timezone_get()));

            $content[] = array(
                $timeEntry['description'],
                $startDate->format('Y-m-d'),
                $startDate->format('H:i:s'),
                $stopDate->format('Y-m-d'),
                $stopDate->format('H:i:s'),
                $timeEntry['pid'],
            );
        }

        $table->setHeaders(array('Description', 'Start day', 'Start hour', 'Stop day', 'Stop hour', 'Project'))->setRows($content)->render($output);
    }
}
