<?php

namespace App\Robot\Contracts;

use App\Models\Game;

interface Player
{
    /**
     * Return the cell location where the Robot must play.
     *
     * @param Game   $game
     * @param string $piece
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function nextMoveIn(Game $game, string $piece): string;
}
