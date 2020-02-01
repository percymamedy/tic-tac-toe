<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCellRequest;
use App\Http\Resources\CellResource;
use App\Models\Cell;
use App\Models\Game;

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

        $cell->updateValue($request->input('value'))->save();

        return CellResource::make($cell);
    }
}
