<?php

namespace Scrumban\Registry;

use Scrumban\Entity\UserStory;

final class TrelloRegistry implements RegistryInterface
{
    /** @var array **/
    private $boards;
    /** @var array **/
    private $columns;
    /** @var array **/
    private $userStories;
    
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
    
    public function storeUserStories(array $userStories = [])
    {
        foreach ($userStories as $userStory) {
            $this->userStories[$userStory->getId()] = $userStory;
        }
    }
    
    public function getUserStory(string $id): ?UserStory
    {
        return $this->userStories[$id] ?? null;
    }
}
