<?php

namespace App\Actions;

use App\Models\Game;
use Spatie\QueueableAction\QueueableAction;

class ResetGame
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @param Game $game
     *
     * @return Game
     */
    public function execute(Game $game): Game
    {
        return tap($game, function (Game $game) {
            $game->markAsUnCompleted()
                 ->resetAllCells()
                 ->save();
        });
    }
}
