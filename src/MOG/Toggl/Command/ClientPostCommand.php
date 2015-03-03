<?php

namespace MOG\Toggl\Command;

use GuzzleHttp\Exception\ClientException;
use MOG\Toggl\Command\AbstractTogglCommand as TogglCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClientPostCommand extends TogglCommand
{
    protected function configure()
    {
        $this
            ->setName('client:post')
            ->setDescription('Create a new client')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating new client...');
        $output->writeln('');

        try {
            $this->client->postClient(
                array(
                    'name' => 'Ozymandias',
                    'wid' => 594413,
                    'notes' => 'Smartest man in the world',
                    'hrate' => 10.0,
                    'cur' => '€',
                    'at' => time(),
                )
            );
        } catch (ClientException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getResponse()->getBody()));
        }
    }
}
