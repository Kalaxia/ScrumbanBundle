<?php

namespace Scrumban\Gateway;

class TrelloGateway extends Gateway
{
    public function getBoard(string $id)
    {
        return $this->get("/1/boards/{$id}");
    }
    
    public function getBoardColumns(string $id)
    {
        return $this->get("/1/boards/{$id}/lists");
    }
    
    public function getColumnCards(string $id)
    {
        return $this->get("/1/lists/{$id}/cards");
    }
    
    public function getCardComments(string $id)
    {
        return $this->get("/1/cards/{$id}/actions?filter=commentCard");
    }
    
    public function createWebhook(string $apiToken, string $apiKey, string $boardId, string $url)
    {
        return $this->post("/1/tokens/{$apiToken}/webhooks/?key={$apiKey}", [
            'description' => 'Scrumban Webhook',
            'callbackUrl' => $url,
            'idModel' => $boardId
        ]);
    }
}