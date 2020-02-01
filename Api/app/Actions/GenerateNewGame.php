<?php

namespace App\Actions;

use App\Models\Game;
use App\Repositories\Games;
use Spatie\QueueableAction\QueueableAction;

class GenerateNewGame
{
    use QueueableAction;

    /**
     * Game repository instance.
     *
     * @var Games
     */
    protected $games;

    /**
     * Generation of Grids action.
     *
     * @var GenerateGridCells
     */
    protected $generateGridCells;

    /**
     * Create a new action instance.
     *
     * @param Games             $games
     * @param GenerateGridCells $generateGridCells
     */
    public function __construct(Games $games, GenerateGridCells $generateGridCells)
    {
        $this->games = $games;
        $this->generateGridCells = $generateGridCells;
    }

    /**
     * Generate a new game.
     *
     * @param int $grid
     *
     * @return Game
     */
    public function execute(int $grid = 3): Game
    {
        return $this->games->create()
                           ->newUpCells($this->generateGridCells->execute($grid));
    }
}
