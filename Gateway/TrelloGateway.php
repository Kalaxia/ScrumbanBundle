<?php

namespace Scrumban\Gateway;

use GuzzleHttp\Client;

class TrelloGateway extends Gateway
{
    /** @var Client **/
    protected $client;
    
    public function __construct($trelloUrl)
    {
        $this->client = new Client(['base_uri' => $trelloUrl]);
    }
    
    public function getBoard(string $id)
    {
        return $this->get("/1/boards/{$id}");
    }
    
    public function getBoardColumns(string $id)
    {
        return $this->get("/1/boards/${id}/lists");
    }
    
    public function getColumnCards(string $id)
    {
        return $this->get("/1/lists/${id}/cards");
    }
}