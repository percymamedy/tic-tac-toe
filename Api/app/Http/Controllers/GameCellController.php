<?php

namespace App\Http\Controllers;

use App\Actions\ProcessCurrentTurn;
use App\Http\Requests\UpdateCellRequest;
use App\Http\Resources\CellResource;
use App\Models\Cell;
use App\Models\Game;

class GameCellController extends Controller
{
    /**
     * Play the player cell and robot response.
     *
     * @param Game               $game
     * @param Cell               $cell
     * @param UpdateCellRequest  $request
     * @param ProcessCurrentTurn $currentTurn
     *
     * @return \Illuminate\Http\Response|CellResource
     */
    public function __invoke(Game $game, Cell $cell, UpdateCellRequest $request, ProcessCurrentTurn $currentTurn)
    {
        return CellResource::make($currentTurn->execute($game, $cell, $request->playerPiece(), $request->robotPiece()));
    }
}
