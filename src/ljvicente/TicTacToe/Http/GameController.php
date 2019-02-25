<?php

namespace TicTacToe\Http;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use TicTacToe\Game\Board;
use TicTacToe\Game\GameState;
use TicTacToe\Game\Player\Move;
use TicTacToe\Game\Player\Bot\MoveGenerator;


class GameController extends BaseController
{
    protected $board;

    protected $board_state;
    
    protected $game_state;

    protected $move;

    protected $generator;

    public function __construct()
    {
        $this->board = new Board;
        $this->game_state = new GameState;
        $this->move = new Move;
        $this->generator = new MoveGenerator;
        
        $this->board_state = $this->board->getState();
    }

    /**
     * Handle reset game session.
     *
     * @return \Illuminate\Http\Response
     */
    public function start(Request $request)
    {
        try {
            $new_board_state = $this->board->create();

            $this->board->setState($new_board_state);

            return $new_board_state;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get current game session.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getBoardState(Request $request)
    {
        try {
            return $this->board_state;
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Submit move.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function submitMove(Request $request)
    {
        $x = $request->get('x');
        $y = $request->get('y');
        $unit = $request->get('unit');
        
        try {
            if (! $this->game_state->isGameDraw($this->board_state) && ! $this->game_state->isGameWon($this->board_state)) {
                // human move
                $next_board_state = $this->move->makeMove($this->board_state, [$x, $y], $unit);
                $current_board_state = $this->board->setState($next_board_state);
            }
    
            if (! $this->game_state->isGameDraw($current_board_state) && ! $this->game_state->isGameWon($current_board_state)) {
                // bot move
                $bot_move = $this->botMove($current_board_state, 'O');
                $next_board_state = $this->move->makeMove($current_board_state, [$bot_move[0], $bot_move[1]], $bot_move[2]);
                $current_board_state = $this->board->setState($next_board_state);
            }
            return $this->board->getState();
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
        
    }

    /**
     * Bot move.
     *
     * @param array $board_state
     * @param string $unit
     * @return array
     */
    private function botMove($board_state, $unit)
    {
        return $this->generator->makeMove($board_state, $unit);
    }

    /**
     * Get status of the game.
     *
     * @return array
     */
    public function getStatus()
    {
        try {
            $board_state = $this->board_state;
            $status = null;
            $winner = null;

            if ($this->game_state->isGameDraw($board_state)) {
                $status = 'draw';
            }

            $won = $this->game_state->isGameWon($board_state);
            if ($won) {
                $status = 'won';
                $winner = $won;
            }

            return [
                'status' => $status,
                'winner' => $winner,
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
