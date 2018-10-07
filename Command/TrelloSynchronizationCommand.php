<?php

namespace Scrumban\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TrelloSynchronizationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('scrumban:trello:sync')
            ->setDescription('Synchronize')
            ->addArgument('board_name', InputArgument::REQUIRED, 'The configured name of the board you want to synchronize')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            "<fg=white;bg=cyan>\n\n Beginning board synchronization !\n</>\n"
        );
        $messages = $this->getContainer()->get('scrumban.trello_manager')->sync($input->getArgument('board_name'));
        
        foreach ($messages as $type => $message) {
            $output->writeln("<{$type}>$message</{$type}>");
        }
        $output->writeln('<fg=white;bg=green>\n\n Synchronization is complete !\n</>\n');
    }
}