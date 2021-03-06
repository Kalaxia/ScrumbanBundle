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
            $spent += (float) array_reverse(explode(' ', $parts[0]))[0];
            $estimated += (float) $parts[1];
        }
        return [
            'estimated' => $estimated,
            'spent' => $spent
        ];
    }
}