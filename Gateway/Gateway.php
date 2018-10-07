<?php

namespace Scrumban\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

abstract class Gateway implements GatewayInterface
{
    /** @var Client **/
    protected $client;
    
    public function __construct(string $baseUri)
    {
        $this->client = new Client(['base_uri' => $baseUri]);
    }
    
    public function get($url): array
    {
        return json_decode($this->client->get($url)->getBody()->getContents(), true);
    }
    
    public function post($url, array $data): array
    {
        return json_decode($this->client->post($url, [
            RequestOptions::JSON => $data
        ])->getBody()->getContents(), true);
    }
}