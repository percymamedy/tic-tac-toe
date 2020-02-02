<?php

namespace App\Http\Controllers;

use App\Events\GameWonByPlayer;
use App\Events\GameWonByRobot;
use App\Http\Requests\UpdateCellRequest;
use App\Http\Resources\CellResource;
use App\Models\Cell;
use App\Models\Game;
use Facades\App\Actions\MoveToNextCell;

class GameCellController extends Controller
{
    /**
     * Update the cell value.
     *
     * @param Game              $game
     * @param Cell              $cell
     * @param UpdateCellRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Game $game, Cell $cell, UpdateCellRequest $request)
    {
        if (!$game->contains($cell)) {
            throw new \InvalidArgumentException('Given cell is not part of this game.');
        }

        $playerPiece = $request->input('value');
        $robotPiece = $request->input('opponent');

        $cell->play($playerPiece);

        // We first check if the User is the winner and if so
        // we don't have to move anymore.
        if ($game->wonBy($playerPiece)) {
            GameWonByPlayer::dispatch(tap($game->markAsCompleted(), function (Game $game) {
                $game->save();
            }));

            return CellResource::make($cell);
        }

        MoveToNextCell::execute($game, $robotPiece, $playerPiece);

        // Now we must check if the Robot is the winner and if so
        // we dispatch the event.
        if ($game->wonBy($robotPiece)) {
            GameWonByRobot::dispatch(tap($game->markAsCompleted(), function (Game $game) {
                $game->save();
            }));
        }

        return CellResource::make($cell);
    }
}
