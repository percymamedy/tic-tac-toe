<?php

namespace App\Robot\Players\Strategies;

use App\Models\Cell;
use Illuminate\Support\Collection;

abstract class BaseStrategy implements Strategy
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
     * These cells combination won't lead to victory in any way for the current move.
     *
     * @param Collection $cells
     * @param array      $combination
     *
     * @return bool
     */
    protected function cannotLeadToSuccess(Collection $cells): bool
    {
        return
            $this->allCellsAreEmpty($cells) ||
            $this->allCellsAreFilled($cells) ||
            $this->onlyOneCellIsFilled($cells);
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

    /**
     * Check to see if the two cells have the correct peice filled in.
     *
     * @param Collection $cells
     * @param string     $peice
     *
     * @return bool
     */
    protected function cellsAreFilledWithPeice(Collection $cells, string $peice): bool
    {
        return $cells->filter->isFilledWith($peice)->count() === 2;
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
}
