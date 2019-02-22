<?php

namespace TicTacToe\Game;

use TicTacToe\Exceptions\InvalidBoardStateException;

/**
 * Board-related activities.
 * 
 * @author Leo <hello@lei.ph>
 */
class Board
{
    protected $enabled = false;

    /**
     * Initializes an empty board.
     *
     * @return array
     */
    public function create()
    {
        return [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];
    }

    /**
     * Enable board for a game.
     *
     * @return void
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Checks if the board is playable.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Gets current board state from session data.
     *
     * @return array
     */
    public function getState()
    {
        // return app('session')->get('board_state');
        if (! isset($_SESSION['board_state'])) {
            $_SESSION['board_state'] = $this->create();
        }
        
        return $_SESSION['board_state'];
    }

    /**
     * Sets current board state to session data.
     *
     * @param array $board_state
     * @return array
     */
    public function setState($board_state)
    {
        $this->validateSubmittedBoardState($board_state);

        // app('session')->put('board_state', $board_state);
        $_SESSION['board_state'] = $board_state;

        return $board_state;
    }

    /**
     * Makes sure that the submitted states
     * are following the proper board state
     * conventions.
     *
     * @param array $board_state
     * @return void
     */
    public function validateSubmittedBoardState($board_state)
    {
        if (! $this->isValidRowCount($board_state)) {
            throw new InvalidBoardStateException("Invalid Row Count.");
        }

        if (! $this->isValidColumnCount($board_state)) {
            throw new InvalidBoardStateException("Invalid Column Count.");
        }

        if (! $this->isValidCellValue($board_state)) {
            throw new InvalidBoardStateException("Invalid Cell Value.");
        }

        if (! $this->isValidGameTurns($board_state)) {
            throw new InvalidBoardStateException("Invalid Game Turns.");
        }
    }

    /**
     * Checks if a cell value is valid.
     *
     * @param array $board_state
     * @return boolean
     */
    private function isValidCellValue($board_state)
    {
        foreach ($board_state as $row) {
            foreach ($row as $value) {
                if (! in_array($value, ['X', 'O', ''])) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Checks if the number of columns is correct.
     *
     * @param array $board_state
     * @return boolean
     */
    private function isValidColumnCount($board_state)
    {
        foreach ($board_state as $row) {
            if (count($row) != 3 || ! is_array($row)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if the number of rows is correct.
     *
     * @param array $board_state
     * @return boolean
     */
    private function isValidRowCount($board_state)
    {
        return count($board_state) == 3 && is_array($board_state);
    }

    /**
     * Checks if the number of turns for each 
     * player is correct.
     *
     * @param array $board_state
     * @return boolean
     */
    private function isValidGameTurns($board_state)
    {
        $player_one_turns = 0;
        $player_two_turns = 0;

        foreach ($board_state as $row) {
            foreach ($row as $value) {
                if ($value == 'X') {
                    $player_one_turns++;
                }

                if ($value == 'O') {
                    $player_two_turns++;
                }
            }
        }

        return abs($player_one_turns - $player_two_turns) <= 1;
    }
}
