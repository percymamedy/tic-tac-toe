<?php

namespace App\Robot\Players;

use App\Exceptions\NoMovesException;
use App\Models\Game;
use App\Robot\Contracts\Player;
use Illuminate\Support\Collection;

class TicTacToeClassicPlayer implements Player
{
    /**
     * Strategies that the player will use to
     * get to the correct move.
     *
     * @var Collection
     */
    protected $strategies;

    /**
     * TicTacToeClassicPlayer constructor.
     *
     * @param Collection $strategies
     */
    public function __construct(Collection $strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * Return the cell location where the Robot must play.
     *
     * @param Game   $game
     * @param string $piece
     * @param string $opponentPiece
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function nextMoveIn(Game $game, string $piece, string $opponentPiece): string
    {
        $cells = $game->cells;

        /** @var Strategies\Strategy $strategy */
        foreach ($this->strategies() as $strategy) {
            $move = $strategy->findMove($cells, $piece, $opponentPiece);

            if (!is_null($move)) {
                return $move;
            }
        }

        throw new NoMovesException('Unable to find a possible move');
    }

    /**
     * Set the current strategies to the player.
     *
     * @param Collection $strategies
     *
     * @return TicTacToeClassicPlayer
     */
    public function loadStrategies(Collection $strategies): TicTacToeClassicPlayer
    {
        $this->strategies = $strategies;

        return $this;
    }

    /**
     * Get the strategies classes that the robot might want to use.
     *
     * @return Collection
     */
    public function strategies(): Collection
    {
        return $this->strategies;
    }
}
