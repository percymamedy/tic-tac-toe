<?php

namespace App\Http\Controllers;

use App\Actions\GenerateNewGame;
use App\Actions\ResetGame;
use App\Http\Requests\CreateNewGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * Create a new game.
     *
     * @param CreateNewGameRequest $request
     * @param GenerateNewGame      $generateNewGame
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewGameRequest $request, GenerateNewGame $generateNewGame)
    {
        return GameResource::make($generateNewGame->execute($request->input('grid')));
    }

    /**
     * Reset a game.
     *
     * @param Game $game
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Game $game, ResetGame $resetGame)
    {
        return GameResource::make($resetGame->execute($game));
    }
}
