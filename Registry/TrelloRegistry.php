<?php

namespace Scrumban\Registry;

final class TrelloRegistry implements RegistryInterface
{
    /** @var array **/
    private $boards;
    /** @var array **/
    private $columns;
    
    public function __construct(array $boards, array $columns)
    {
        $this->boards = $boards;
        $this->columns = $columns;
    }
    
    public function hasBoard(string $name): bool
    {
        return isset($this->boards[$name]);
    }
    
    public function getBoard(string $name): ?array
    {
        if ($this->hasBoard($name)) {
            return $this->boards[$name];
        }
        return null;
    }
    
    public function hasColumn(string $name): bool
    {
        return isset($this->columns[$name]);
    }
    
    public function getColumn(string $name): ?array
    {
        if ($this->hasColumn($name)) {
            return $this->columns[$name];
        }
        return null;
    }
}
