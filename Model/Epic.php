<?php

namespace Scrumban\Model;

abstract class Epic implements CardInterface, EstimableInterface
{
    /** @var string **/
    protected $id;
    /** @var string **/
    protected $title;
    /** @var string **/
    protected $status;
    /** @var float **/
    protected $estimatedTime;
    /** @var float **/
    protected $spentTime;
    /** @var \DateTime **/
    protected $createdAt;
    /** @var \DateTime **/
    protected $updatedAt;
    
    public function getCardType(): string
    {
        return self::CARD_TYPE_EPIC;
    }
    
    public function setId(string $id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setStatus(string $status): CardInterface
    {
        $this->status = $status;
        
        return $this;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function setEstimatedTime(float $estimatedTime): EstimableInterface
    {
        $this->estimatedTime = $estimatedTime;
        
        return $this;
    }
    
    public function getEstimatedTime(): float
    {
        return $this->getEstimatedTime();
    }
    
    public function setSpentTime(float $spentTime): EstimableInterface
    {
        $this->spentTime = $spentTime;
    }
    
    public function getSpentTime(): float
    {
        return $this->spentTime;
    }
    
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}