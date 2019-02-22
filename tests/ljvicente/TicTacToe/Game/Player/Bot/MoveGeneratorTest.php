<?php

use TicTacToe\Game\Player\Bot\MoveGenerator;

class MoveGenerateTest extends TestCase
{
    protected $generator;
    
    public function setUp()
    {
        $this->generator = new MoveGenerator;
    }

    public function testCanGenerateValidMove()
    {
        $board_state = [
            ['X', 'O', 'X'],
            ['', 'O', 'O'],
            ['', 'X', 'X'],
        ];
        $next_move = $this->generator->makeMove($board_state, 'O');
        
        $this->assertContains($next_move, [[1, 0, 'O'], [2, 0, 'O']]);

        $board_state = [
            ['X', 'O', 'X'],
            ['', 'O', 'O'],
            ['O', 'X', 'X'],
        ];
        $next_move = $this->generator->makeMove($board_state, 'X');
        $this->assertContains($next_move, [[1, 0, 'X']]);
    }
}
