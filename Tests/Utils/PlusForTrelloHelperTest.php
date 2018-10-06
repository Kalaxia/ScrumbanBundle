<?php

namespace Tests\Utils;

use Scrumban\Utils\PlusForTrelloHelper;

class PlusForTrelloHelperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testExtractEstimations($comments, $expectedEstimations)
    {
        $this->assertEquals($expectedEstimations, PlusForTrelloHelper::extractEstimations($comments));
    }
    
    public function provideData()
    {
        return [
            [
                [
                    [
                        'data' => [ 'text' => 'plus! 0/6' ]
                    ],
                    [
                        'data' => [ 'text' => 'plus! 2/0' ]
                    ],
                    [
                        'data' => [ 'text' => 'plus! 1/0' ]
                    ]
                ],
                [
                    'estimated' => 6,
                    'spent' => 3
                ]
            ],
            [
                [
                    [
                        'data' => [ 'text' => 'plus! 0/3' ]
                    ],
                    [
                        'data' => [ 'text' => 'plus! 2/0' ]
                    ],
                    [
                        'data' => [ 'text' => 'plus! @developer 2/1' ]
                    ]
                ],
                [
                    'estimated' => 4,
                    'spent' => 4
                ]
            ]
        ];
    }
}