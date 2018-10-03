<?php

namespace Scrumban\Model;

interface CardInterface
{
    const CARD_TYPE_US = 'user_story';
    const CARD_TYPE_EPIC = 'epic';
    const CARD_TYPE_TECH = 'tech';
    
    public function getCardType(): string;
}