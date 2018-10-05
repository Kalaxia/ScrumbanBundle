<?php

namespace Scrumban\Registry;

interface RegistryInterface
{
    public function getBoard(string $name): ?array;
    
    public function getColumn(string $name): ?array;
}