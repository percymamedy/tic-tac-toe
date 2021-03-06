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
        return $this->renderGame($generateNewGame->execute($request->input('grid')));
    }

    /**
     * Show a game.
     *
     * @param Game $game
     *
     * @return GameResource
     */
    public function show(Game $game)
    {
        return $this->renderGame($game);
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
        return $this->renderGame($resetGame->execute($game));
    }

    /**
     * Render a game using game resource.
     *
     * @param Game $game
     *
     * @return GameResource
     */
    protected function renderGame(Game $game): GameResource
    {
        return GameResource::make($game);
    }
}
