<?php

namespace Scrumban\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Psr\Log\LoggerInterface;

class WebhookController extends Controller 
{
    /**
     * @Route("/trello/webhook", name="scrumban_trello_webhook", methods={"POST"})
     */
    public function trelloWebhookAction(Request $request, LoggerInterface $logger)
    {
        $logger->critical(dump($request->getContent()));
        
        return new Response('', 200);
    }
    
    /**
     * @Route("/trello/webhook", name="scrumban_active_trello_webhook", methods={"GET"})
     */
    public function trelloWebhookActivationAction(Request $request, LoggerInterface $logger)
    {
        $logger->info(dump($request->query->all()));
        
        return new Response('', 200);
    }
}