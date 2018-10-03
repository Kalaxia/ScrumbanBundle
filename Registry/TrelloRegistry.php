<?php

namespace Scrumban\Registry;

final class TrelloRegistry
{
    /** @var array **/
    private $boards;
    
    public function __construct(array $boards)
    {
        $this->boards = $boards;
    }
    
    public function hasBoard(string $name)
    {
        return isset($this->boards[$name]);
    }
    
    public function getBoard(string $name)
    {
        if ($this->hasBoard($name)) {
            return $this->boards[$name];
        }
        return null;
    }
}
