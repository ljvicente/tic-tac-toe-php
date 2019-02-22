<?php

namespace TicTacToe\Game\Player\Bot;

use TicTacToe\Game\Board;
use TicTacToe\Game\Player\Bot\MoveInterface;

/**
 * Bot moves.
 * 
 * @author Leo <hello@lei.ph>
 */
class MoveGenerator implements MoveInterface
{
    /**
     * Generate next move.
     *
     * @param array $board_state
     * @param string $player_unit
     * @return array
     */
    public function makeMove(array $board_state, string $player_unit = 'X') : array
    {
        $valid_moves = [];

        foreach ($board_state as $row_number => $row) {
            foreach ($row as $column_number => $value) {
                if ($value == '') {
                    $valid_moves[] = [$row_number, $column_number];
                }
            }
        }
        $possible_move_count = count($valid_moves);
        // generate random, dumb moves..
        if ($possible_move_count > 0) {
            $next_move = $valid_moves[rand(0, count($valid_moves) - 1)];
            return [$next_move[0], $next_move[1], $player_unit];
        }
        return [];
    }
}
