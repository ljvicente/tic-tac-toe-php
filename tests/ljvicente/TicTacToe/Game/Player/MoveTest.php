<?php

use TicTacToe\Game\Player\Move;
use TicTacToe\Game\Board;

class MoveTest extends TestCase
{
    protected $move;

    protected $board;

    public function setUp()
    {
        $this->move = new Move;
        $this->board = new Board;
    }

    /**
     * @param array $move
     * @expectedException \TicTacToe\Exceptions\InvalidMoveException
     * @expectedExceptionMessage Board cell is taken.
     * @dataProvider invalidMoveProvider
     */
    public function testCanValidateSubmittedMove(array $move)
    {
        $this->move->validate([
            ['X', 'O', 'X'],
            ['O', 'X', ''],
            ['X', 'O', ''],
        ], $move);
    }

    public function invalidMoveProvider() : array
    {
        return [
            // [x, y]
            [
                [0, 2],
                [1, 1],
                [1, 0],
                [2, 1],
            ],
        ];
    }

    /**
     * @param array $move
     * @expectedException \TicTacToe\Exceptions\InvalidMoveException
     * @expectedExceptionMessage Invalid Move Format.
     * @dataProvider invalidMoveFormatProvider
     */
    public function testCanValidateSubmittedMoveFormat(array $move)
    {
        $this->move->validate([
            ['X', 'O', 'X'],
            ['O', 'X', ''],
            ['X', 'O', ''],
        ], $move);
    }

    public function invalidMoveFormatProvider() : array
    {
        return [
            // [x, y]
            [
                [0],
                [],
                1,
                "1,2"
            ],
        ];
    }

    public function testCanMakeMove()
    {
        $board_state = $this->board->create();
        $board_state = $this->move->makeMove($board_state, [0, 0], "X");
        
        $this->assertEquals($board_state, [
            ['X', '', ''],
            ['', '', ''],
            ['', '', ''],
        ]);

        $board_state = [
            ['X', 'O', ''],
            ['', 'X', ''],
            ['', '', 'O'],
        ];
        $board_state = $this->move->makeMove($board_state, [1, 0], "X");
        $this->assertEquals($board_state, [
            ['X', 'O', ''],
            ['X', 'X', ''],
            ['', '', 'O'],
        ]);
    }
}
