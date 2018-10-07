<?php

namespace Scrumban\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends Controller 
{
    /**
     * @Route("/trello/webhook", name="scrumban_trello_webhook", methods={"POST"})
     */
    public function trelloWebhookAction(Request $request)
    {
        dump($request->request->all());
    }
}