<?php

namespace App\Concerns;

use Illuminate\Support\Collection;

trait Gameable
{
    /**
     * These are the combinations we can use to win.
     *
     * @var array
     */
    protected $winningCombinations = [
        ['A1', 'A2', 'A3'],
        ['B1', 'B2', 'B3'],
        ['C1', 'C2', 'C3'],
        ['A1', 'B1', 'C1'],
        ['A2', 'B2', 'C2'],
        ['A3', 'B3', 'C3'],
        ['A1', 'B2', 'C3'],
        ['A3', 'B2', 'C1'],
    ];

    /**
     * Check to see if the given number of cells have
     * the correct peice filled in.
     *
     * @param Collection $cells
     * @param string     $peice
     * @param int        $number
     *
     * @return bool
     */
    protected function cellsAreFilledWithPeice(Collection $cells, string $peice, int $number = 2)
    {
        return $cells->filter->isFilledWith($peice)->count() === $number;
    }

    /**
     * Get cells in the given combination.
     *
     * @param Collection $cells
     * @param array      $combination
     *
     * @return Collection
     */
    protected function combinationCells(Collection $cells, array $combination): Collection
    {
        return $cells->whereIn('location', $combination);
    }

    /**
     * Get the combinations which can allow the player to win.
     *
     * @return array
     */
    protected function calculateWinningCombinations(): array
    {
        return $this->winningCombinations;
    }
}
