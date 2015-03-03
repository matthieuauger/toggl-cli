<?php

namespace MOG\Toggl\Command;

use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClientGetCommand extends TogglCommand
{
    private $clientId;

    protected function configure()
    {
        $this
            ->setName('client:get')
            ->setDescription('Get client details')
            ->addArgument(
                'client',
                InputArgument::OPTIONAL,
                'The client identifer'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        if (null !== $input->getArgument('client')) {
            $this->clientId = $input->getArgument('client');
        } else {
            $this->clientId = $this->config['client'];
        }

        if (null === $this->clientId) {
            throw new \Exception('No client found : You must either give a client to the command or configure one in the app/config/parameters.yml file');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Client details');
        $output->writeln('');

        $client = $this->client->getClient(
            array(
                'cid' => (int) $this->clientId,
            )
        );

        $this->displayClient($output, $client);
    }

    private function displayClient(OutputInterface $output, $client)
    {
        $table = $this->getHelperSet()->get('table');

        $content = array();
        foreach ($client['data'] as $fieldName => $fieldValue) {
            $content[] = array($fieldName, $fieldValue);
        }

        $table->setRows($content)->render($output);
    }
}
