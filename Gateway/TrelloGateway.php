<?php

namespace Scrumban\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class TrelloGateway
{
    /** @var Client **/
    protected $client;
    
    public function __construct($trelloUrl)
    {
        $this->client = new Client(['base_uri' => $trelloUrl]);
    }
    
    public function getBoard(string $id)
    {
        return $this->client->get("/1/boards/{$id}")->getBody()->getContents();
    }
}