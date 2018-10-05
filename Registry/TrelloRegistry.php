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
    
    public function getBoard(string $name): ?array
    {
        return $this->boards[$name] ?? null;
    }
    
    public function getColumn(string $name): ?array
    {
        foreach ($this->columns as $column) {
            if ($column['name'] === $name) {
                return $column;
            }
        }
        return null;
    }
}
