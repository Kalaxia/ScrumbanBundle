<?php

namespace Scrumban\Utils;

class PlusForTrelloHelper
{
    const PREFIX = 'plus!';
    
    public static function extractEstimations(array $comments): array
    {
        $estimated = 0;
        $spent = 0;
        foreach ($comments as $comment) {
            $text = $comment['data']['text'];
            if (strpos($text, static::PREFIX) === false) {
                continue;
            }
            $parts = explode('/', $text);
            $estimated += (float) $parts[0];
            $spent += (float) $parts[1];
        }
        return [
            'estimated' => $estimated,
            'spent' => $spent
        ];
    }
}