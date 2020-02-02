<?php

namespace App\Actions;

use App\Events\MovePlayed;
use App\Models\Cell;
use App\Models\Game;
use App\Robot\Contracts\Player;
use Spatie\QueueableAction\QueueableAction;

class MoveToNextCell
{
    use QueueableAction;

    /**
     * The AI robot player.
     *
     * @var Player
     */
    protected $robot;

    /**
     * MoveToNextCell constructor.
     *
     * @param Player $robot
     */
    public function __construct(Player $robot)
    {
        $this->robot = $robot;
    }

    /**
     * Execute the action.
     *
     * @param Game   $game
     * @param string $piece
     * @param string $opponentPiece
     *
     * @return void
     */
    public function execute(Game $game, string $piece, string $opponentPiece)
    {
        $game->load('cells');

        $nextCellToMove = $this->getNextCellToMove($game, $piece, $opponentPiece);
        $nextCellToMove->play($piece);

        MovePlayed::dispatch($game, $nextCellToMove);
    }

    /**
     * Get the next cell the Ai can move to.
     *
     * @param Game   $game
     * @param string $piece
     * @param string $opponentPiece
     *
     * @return Cell|null
     */
    protected function getNextCellToMove(Game $game, string $piece, string $opponentPiece): ?Cell
    {
        return $game->cells()
                    ->where('location', $this->robot->nextMoveIn($game, $piece, $opponentPiece))
                    ->first();
    }
}
