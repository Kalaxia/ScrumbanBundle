<?php

namespace Scrumban\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;

use Scrumban\Manager\SprintManager;

class SprintCreationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('scrumban:sprint:create')
            ->setDescription('Create a new sprint')
            ->addOption('begin', null, InputOption::VALUE_OPTIONAL, 'Sprint begin date')
            ->addOption('end', null, InputOption::VALUE_OPTIONAL, 'Sprint end date')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        if(($begin = $input->getOption('begin')) === null) {
            $begin = $helper->ask($input, $output, new Question('Please enter the sprint begin date: '));
        }
        if(($end = $input->getOption('end')) === null) {
            $end = $helper->ask($input, $output, new Question('Please enter the sprint end date: '));
        }
        $sprint = $this->getContainer()->get(SprintManager::class)->createSprint(new \DateTime($begin), new \DateTime($end));
        
        $output->writeln(
            "<fg=white;bg=green>\n\n Sprint {$sprint->getId()} created ! It will be active from {$sprint->getBeginAt()->format('c')} to {$sprint->getEndedAt()->format('c')}\n</>\n"
        );
    }
}