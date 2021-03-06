<?php

namespace TicTacToe\Game\Player;

use TicTacToe\Exceptions\InvalidMoveException;

/**
 * Player moves.
 * 
 * @author Leo <hello@lei.ph>
 */
class Move
{
    /**
     * Submits move.
     *
     * @param array $board_state
     * @param array $coordinate
     * @param string $unit
     * @return void
     */
    public function makeMove($board_state, $coordinate, $unit)
    {
        $this->validate($board_state, $coordinate);
        
        $board_state[$coordinate[0]][$coordinate[1]] = $unit;

        return $board_state;
    }

    /**
     * Validate submitted move.
     *
     * @param array $board_state
     * @param array $move
     * @return void
     */
    public function validate($board_state, $move)
    {
        if (! is_array($move) || (is_array($move) && count($move) != 2)) {
            throw new InvalidMoveException('Invalid Move Format.');
        }

        if ($board_state[$move[0]][$move[1]] != '') {
            throw new InvalidMoveException('Board cell is taken.');
        }
    }
}
