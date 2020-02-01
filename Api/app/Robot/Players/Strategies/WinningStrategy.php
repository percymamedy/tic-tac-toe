<?php

namespace App\Robot\Players\Strategies;

use App\Models\Cell;
use Illuminate\Support\Collection;

class WinningStrategy implements Strategy
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
     * Find the move within the given cells.
     *
     * @param Collection $cells
     * @param string     $peice
     *
     * @return null|string
     */
    public function findMove(Collection $cells, string $peice): ?string
    {
        foreach ($this->calculateWinningCombinations() as $combination) {
            $combinationCells = $cells->whereIn('location', $combination);

            if (
                $this->allCellsAreEmpty($combinationCells) ||
                $this->allCellsAreFilled($combinationCells) ||
                $this->onlyOneCellIsFilled($combinationCells)
            ) {
                continue;
            }

            if ($this->cellsAreFilledWithCorrectPeice($combinationCells, $peice)) {
                return $this->findMissingPiece($combinationCells)->location;
            }
        }

        return null;
    }

    /**
     * Will check if all cell are empty.
     *
     * @param Collection $cells
     *
     * @return bool
     */
    protected function allCellsAreEmpty(Collection $cells): bool
    {
        return $cells->filter->isEmpty()->count() === $cells->count();
    }

    /**
     *  Get the cell with the missing value.
     *
     * @param Collection $cells
     *
     * @return Cell
     */
    protected function findMissingPiece(Collection $cells): Cell
    {
        return $cells->filter->isEmpty()->first();
    }

    /**
     * Check to see if the two cells have the correct peice filled in.
     *
     * @param Collection $cells
     * @param string     $peice
     *
     * @return bool
     */
    protected function cellsAreFilledWithCorrectPeice(Collection $cells, string $peice): bool
    {
        return $cells->filter->isFilledWith($peice)->count() === 2;
    }

    /**
     * Checks if only one of the cell is filled.
     *
     * @param Collection $cells
     *
     * @return bool
     */
    protected function onlyOneCellIsFilled(Collection $cells): bool
    {
        return $cells->filter->isFilled()->count() === 1;
    }

    /**
     * Checks if all the cells are filled.
     *
     * @param Collection $cells
     *
     * @return bool
     */
    protected function allCellsAreFilled(Collection $cells): bool
    {
        return $cells->filter->isFilled()->count() === $cells->count();
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
