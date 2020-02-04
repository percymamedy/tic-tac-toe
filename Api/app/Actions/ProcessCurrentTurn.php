<?php

namespace App\Actions;

use App\Events\GameDraw;
use App\Events\GameWonByPlayer;
use App\Events\GameWonByRobot;
use App\Exceptions\NoMovesException;
use App\Models\Cell;
use App\Models\Game;
use Illuminate\Validation\UnauthorizedException;
use Spatie\QueueableAction\QueueableAction;

class ProcessCurrentTurn
{
    use QueueableAction;

    /**
     * Action to move to next cell.
     *
     * @var MoveToNextCell
     */
    protected $nextCell;

    /**
     * ProcessCurrentTurn constructor.
     *
     * @param MoveToNextCell $nextCell
     */
    public function __construct(MoveToNextCell $nextCell)
    {
        $this->nextCell = $nextCell;
    }

    /**
     * Execute the action.
     *
     * @param Game   $game
     * @param Cell   $cell
     * @param string $playerPiece
     * @param string $robotPiece
     *
     * @return Cell
     */
    public function execute(Game $game, Cell $cell, string $playerPiece, string $robotPiece): Cell
    {
        $this->validateCell($game, $cell);

        return $this->playerMove($game, $cell, $playerPiece) ?? $this->robotMove($game, $cell, $robotPiece, $playerPiece);
    }

    /**
     * Move the player piece and check if he won.
     *
     * @param Game   $game
     * @param Cell   $cell
     * @param string $piece
     *
     * @return Cell|null
     */
    protected function playerMove(Game $game, Cell $cell, string $piece): ?Cell
    {
        $cell->play($piece);

        if ($game->wonBy($piece)) {
            $this->dispatchGameEvent($game, GameWonByPlayer::class);

            return $cell;
        }

        return null;
    }

    /**
     * Process the Robot turn to make a move.
     *
     * @param Game   $game
     * @param Cell   $cell
     * @param string $piece
     * @param string $opponentPiece
     *
     * @return Cell
     */
    protected function robotMove(Game $game, Cell $cell, string $piece, string $opponentPiece): Cell
    {
        try {
            $this->nextCell->execute($game, $piece, $opponentPiece);

            if ($game->wonBy($piece)) {
                $this->dispatchGameEvent($game, GameWonByRobot::class);
            }
        } catch (NoMovesException $exception) {
            $this->dispatchGameEvent($game, GameDraw::class);
        }

        return $cell;
    }

    /**
     * Dispatch the appropriate game event.
     *
     * @param Game   $game
     * @param string $event
     *
     * @return void
     */
    protected function dispatchGameEvent(Game $game, string $event)
    {
        $message = new $event(tap($game->markAsCompleted(), function (Game $game) {
            $game->save();
        }));

        event($message);
    }

    /**
     * Validate if the Game can be played with the given cell.
     *
     * @param Game $game
     * @param Cell $cell
     *
     * @return bool
     *
     * @throws UnauthorizedException
     */
    protected function validateCell(Game $game, Cell $cell): bool
    {
        if (!$game->contains($cell)) {
            throw new UnauthorizedException('Given cell is not part of this game.');
        }

        return true;
    }
}
