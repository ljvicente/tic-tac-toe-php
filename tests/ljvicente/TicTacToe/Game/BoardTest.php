<?php

use TicTacToe\Game\Board;

class BoardTest extends TestCase
{
    protected $board;

    public function setUp()
    {
        $this->board = new Board;
    }

    public function testCanCreateBoard()
    {
        $this->assertEquals($this->board->create(), [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ]);
    }

    /**
     * @param array $board_state
     * @dataProvider invalidCellValueProvider
     * @expectedException \TicTacToe\Exceptions\InvalidBoardStateException
     * @expectedExceptionMessage Invalid Cell Value.
     */
    public function testCanValidateCellValues(array $board_state)
    {
        $this->board->validateSubmittedBoardState($board_state);
    }

    /**
     * @return array
     */
    public function invalidCellValueProvider() : array
    {
        return [
            // Invalid Cell Value
            [
                [
                    ['O', 'X', 'O',],
                    ['O', 'X', 'X'],
                    ['', '', 'OOO'],
                ],
            ],
            [
                [
                    ['O', 'X', ''],
                    ['O', 'X', 'X'],
                    [1, 'O', ''],
                ],
            ],
        ];
    }

    /**
     * @param array $board_state
     * @dataProvider invalidColumnsProvider
     * @expectedException \TicTacToe\Exceptions\InvalidBoardStateException
     * @expectedExceptionMessage Invalid Column Count.
     */
    public function testCanValidateColumns(array $board_state)
    {
        $this->board->validateSubmittedBoardState($board_state);
    }

    /**
     * @return array
     */
    public function invalidColumnsProvider() : array
    {
        return [
            [
                [
                    ['O', 'X', 'O', 'X'],
                    ['O', 'X', 'X'],
                    ['', '', ''],
                ],
            ],
            [
                [
                    ['O', 'X'],
                    ['O', 'X', 'X'],
                    ['', '', ''],
                ],
            ],
        ];
    }

    /**
     * @param array $board_state
     * @dataProvider invalidRowsProvider
     * @expectedException \TicTacToe\Exceptions\InvalidBoardStateException
     * @expectedExceptionMessage Invalid Row Count.
     */
    public function testCanValidateRows(array $board_state)
    {
        $this->board->validateSubmittedBoardState($board_state);
    }

    /**
     * @return array
     */
    public function invalidRowsProvider() : array
    {
        return [
            [
                [
                    ['O', 'X'],
                    ['O', 'X', 'X'],
                ],
                [
                    ['X', '', ''],
                    ['', 'X', 'O'],
                    ['O', 'X', 'O', ''],
                    ['X', 'O', ''],
                ],
            ],
        ];
    }

    /**
     * @param array $board_state
     * @dataProvider invalidGameTurnsProvider
     * @expectedException \TicTacToe\Exceptions\InvalidBoardStateException
     * @expectedExceptionMessage Invalid Game Turns.
     */
    public function testCanValidateGameTurns(array $board_state)
    {
        $this->board->validateSubmittedBoardState($board_state);
    }

    /**
     * @return array
     */
    public function invalidGameTurnsProvider() : array
    {
        return [
            [
                [
                    ['X', 'X', 'X'],
                    ['X', 'X', 'X'],
                    ['X', 'X', 'O'],
                ],
                [
                    ['O', '', ''],
                    ['O', '', ''],
                    ['', '', ''],
                ],
            ],
        ];
    }

    public function testCanEnableBoard()
    {
        $this->board->enable();
        $this->assertEquals($this->board->isEnabled(), true);
    }
}
