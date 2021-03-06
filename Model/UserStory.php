<?php

namespace Scrumban\Model;

abstract class UserStory implements CardInterface, EstimableInterface
{
    /** @var string **/
    protected $id;
    /** @var string **/
    protected $title;
    /** @var string **/
    protected $description;
    /** @var int **/
    protected $value;
    /** @var string **/
    protected $status;
    /** @var float **/
    protected $estimatedTime;
    /** @var float **/
    protected $spentTime;
    /** @var Sprint **/
    protected $sprint;
    /** @var Epic **/
    protected $epic;
    /** @var \DateTime **/
    protected $createdAt;
    /** @var \DateTime **/
    protected $updatedAt;
    
    public function getCardType(): string
    {
        return self::CARD_TYPE_US;
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
    
    public function setDescription(string $description): self
    {
        $this->description = $description;
        
        return $this;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setValue(int $value): self
    {
        $this->value = $value;
        
        return $this;
    }
    
    public function getValue(): int
    {
        return $this->value;
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
        return $this->estimatedTime;
    }
    
    public function setSpentTime(float $spentTime): EstimableInterface
    {
        $this->spentTime = $spentTime;
        
        return $this;
    }
    
    public function getSpentTime(): float
    {
        return $this->spentTime;
    }
    
    public function setSprint(Sprint $sprint): self
    {
        $this->sprint = $sprint;
        
        return $this;
    }
    
    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }
    
    public function setEpic(Epic $epic): self
    {
        $this->epic = $epic;
        
        return $this;
    }
    
    public function getEpic(): ?Epic
    {
        return $this->epic;
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