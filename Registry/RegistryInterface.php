<?php

namespace Scrumban\Registry;

interface RegistryInterface
{
    public function hasBoard(string $name): bool;
    
    public function getBoard(string $name): ?array;
    
    public function hasColumn(string $name): bool;
    
    public function getColumn(string $name): ?array;
}