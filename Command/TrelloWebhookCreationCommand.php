<?php

namespace Scrumban\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TrelloWebhookCreationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('scrumban:trello:create-webhook')
            ->setDescription('Create the webhook between Trello and your application')
            ->addArgument('board_name', InputArgument::REQUIRED, 'The configured name of the board you want to create a webhook with')
            ->addOption('callback', null, InputOption::VALUE_OPTIONAL, 'Webhook callback URL (will be suffixed with /trello/webhook)')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(($callbackUrl = $input->getOption('callback')) === null) {
            $callbackUrl = $this->getHelper('question')->ask($input, $output, new Question('Please type your application URL: '));
        }
        $response = $this->getContainer()->get('scrumban.trello_manager')->createWebhook(
            $input->getArgument('board_name'),
            "{$callbackUrl}/{$this->getContainer()->get(UrlGeneratorInterface::class)->generate('scrumban_trello_webhook')}"
        );
        
        dump($response);
            
        $output->writeln('<fg=white;bg=green>\n\n Webhook successfully created !\n</>\n');
    }
}