<?php

namespace Scrumban\Gateway;

abstract class Gateway
{
    public function get($url)
    {
        return json_decode($this->client->get($url)->getBody()->getContents(), true);
    }
}