<?php

require_once dirname(__FILE__) . '/../abstractions/IGameWorld.php';
require_once dirname(__FILE__) . '/DeadCell.php';
require_once dirname(__FILE__) . '/LiveCell.php';

class ExampleWorld extends EmptyWorld
{
    private static array $liveCellsAtStart = [
        [5, 1], [5, 2], [6, 1], [6, 2],
        [5, 11], [6, 11], [7, 11],
        [4, 12], [8, 12],
        [3, 13], [9, 13],
        [3, 14], [9, 14],
        [6, 15],
        [4, 16], [8, 16],
        [5, 17], [6, 17], [7, 17], [6, 18],
        [3, 21], [4, 21], [5, 21],
        [3, 22], [4, 22], [5, 22],
        [2, 23], [6, 23],
        [1, 25], [2, 25], [6, 25], [7, 25],
        [3, 35], [4, 35],
        [3, 36], [4, 36]
    ];

    public function __construct()
    {
        parent::__construct(null, 11, 40);

        foreach (self::$liveCellsAtStart as $cell) {
            $this->state[$cell[0]][$cell[1]] = new LiveCell();
        }
    }
}