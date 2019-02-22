<?php

use TicTacToe\Game\GameState;

class GameStateTest extends TestCase
{
    public function setUp()
    {
        $this->game_state = new GameState;
    }

 
    public function testCanGetPlayerPositions()
    {
        $board_state = [
            ['O', 'X', 'O',],
            ['O', 'X', 'X'],
            ['', '', ''],
        ];

        $x_positions = $this->game_state->getPlayerPositions($board_state, 'X');
        $this->assertEquals($x_positions, [
            [0, 1],
            [1, 1],
            [1, 2],
        ]);
        
        $o_positions = $this->game_state->getPlayerPositions($board_state, 'O');
        $this->assertEquals($o_positions, [
            [0, 0],
            [0, 2],
            [1, 0],
        ]);
    }

    /**
     * @param array $board_state
     * @dataProvider winningCombinationProvider
     */
    public function testCanIdentifyWonGame(array $board_state)
    {
        $has_winner = $this->game_state->isGameWon($board_state) != false;
        $this->assertTrue($has_winner);
    }

    /**
     * @return array
     */
    public function winningCombinationProvider() : array
    {
        return [
            [
                [
                    ['O', 'X', 'O',],
                    ['O', 'X', 'X'],
                    ['', 'X', ''],
                ],
            ],
            [
                [
                    ['X', 'O', 'X'],
                    ['X', 'X', ''],
                    ['O', 'O', 'O'],
                ],
            ],
            [
                [
                    ['X', 'O', 'X'],
                    ['X', 'X', 'O'],
                    ['O', 'O', 'X'],
                ],
            ],
            [
                [
                    ['', 'O', 'X'],
                    ['', 'X', 'O'],
                    ['X', '', ''],
                ],
            ],
        ];
    }

    /**
     * @param array $board_state
     * @dataProvider drawCombinationProvider
     */
    public function testCanIdentifyDrawGame(array $board_state)
    {
        $this->assertTrue($this->game_state->isGameDraw($board_state));
    }

    /**
     * @return array
     */
    public function drawCombinationProvider() : array
    {
        return [
            [
                [
                    ['X', 'O', 'X'],
                    ['X', 'O', 'O'],
                    ['O', 'X', 'X'],
                ],
            ],
            [
                [
                    ['O', 'X', 'X'],
                    ['X', 'O', 'O'],
                    ['O', 'X', 'X'],
                ],
            ],
            [
                [
                    ['X', 'O', 'X'],
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                ],
            ],
        ];
    }
}
