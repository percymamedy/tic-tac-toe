<?php

namespace App\Robot\Players;

use App\Models\Game;
use App\Robot\Contracts\Player;
use Illuminate\Support\Collection;
use App\Robot\Players\Strategies;

class TicTacToeClassicPlayer implements Player
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
    public function nextMoveIn(Game $game, string $piece): string
    {
        $cells = $game->cells;

        /** @var Strategies\Strategy $strategy */
        foreach ($this->strategies() as $strategy) {
            $move = $strategy->findMove($cells, $piece);

            if (!is_null($move)) {
                return $move;
            }
        }

        throw new \RuntimeException('Unable to find a possible move');
    }

    /**
     * Get the strategies classes that the robot might want to use.
     *
     * @return Collection
     */
    protected function strategies(): Collection
    {
        return collect([
            resolve(Strategies\WinningStrategy::class),
        ]);
    }
}
