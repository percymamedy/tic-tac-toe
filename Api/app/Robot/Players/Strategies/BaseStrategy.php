<?php

namespace App\Robot\Players\Strategies;

use App\Concerns\Gameable;
use App\Models\Cell;
use Illuminate\Support\Collection;

abstract class BaseStrategy implements Strategy
{
    use Gameable;

    /**
     * These cells combination won't lead to victory in any way for the current move.
     *
     * @param Collection $cells
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
     * The first free cell.
     *
     * @param Collection $cells
     * @param array      $locations
     *
     * @return Cell|null
     */
    protected function findFirstFree(Collection $cells, array $locations): ?Cell
    {
        return $cells->whereIn('location', $locations)->filter->isEmpty()->first();
    }
}
