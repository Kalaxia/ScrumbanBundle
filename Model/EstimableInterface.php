<?php

namespace Scrumban\Model;

interface EstimableInterface
{
    public function setEstimatedTime(float $estimatedTime): self;
    
    public function getEstimatedTime(): float;
    
    public function setSpentTime(float $spentTime): self;
    
    public function getSpentTime(): float;
}