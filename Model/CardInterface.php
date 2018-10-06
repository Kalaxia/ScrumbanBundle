<?php

namespace Scrumban\Model;

interface CardInterface
{
    const CARD_TYPE_US = 'user_story';
    const CARD_TYPE_EPIC = 'epic';
    const CARD_TYPE_TECH = 'tech';
    
    const STATUS_READY = 'ready';
    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW = 'review';
    const STATUS_TO_RELEASE = 'to_release';
    const STATUS_DONE=  'done';
    
    public function getCardType(): string;
    
    public function setStatus(string $status): self;
    
    public function getStatus(): string;
}