<?php

namespace Scrumban\Utils;

use Scrumban\Model\CardInterface;

class CardHelper
{
    public static function extractValue(string $extraData): int
    {
        if (strtoupper($extraData{0}) !== 'V') {
            return 0;
        }
        return (int) substr($extraData, 1, 3);
    }
    
    public static function extractEstimatedTime(string $cardTitle): int
    {
        return 0;
    }
    
    public static function extractSpentTime(string $cardTitle): int
    {
        return 0;
    }
    
    public static function extractCreationDate(array $card): \DateTime
    {
        return (new \DateTime())->setTimestamp(hexdec(substr($card['id'], 0, 8)));
    }
    
    public static function isInCurrentSprint(string $status): bool
    {
        return in_array($status, [
            CardInterface::STATUS_TODO,
            CardInterface::STATUS_IN_PROGRESS,
            CardInterface::STATUS_REVIEW,
            CardInterface::STATUS_TO_RELEASE
        ]);
    }
    
    public static function slugify($name)
    {
        return str_replace(' ', '_', strtolower($name));
    }
}