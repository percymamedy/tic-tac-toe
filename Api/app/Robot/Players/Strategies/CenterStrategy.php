<?php

namespace App\Robot\Players\Strategies;

use App\Models\Cell;
use Illuminate\Support\Collection;

class CenterStrategy extends BaseStrategy
{
    /**
     * The center cell.
     *
     * @var string
     */
    protected $centerCell = 'B2';

    /**
     * Find the move within the given cells.
     *
     * @param Collection $cells
     * @param string     $piece
     * @param string     $opponentPiece
     *
     * @return null|string
     */
    public function findMove(Collection $cells, string $piece, string $opponentPiece): ?string
    {
        return optional($this->getCenterCellIfFree($cells))->location;
    }

    /**
     * Get the center cell to play.
     *
     * @param Collection $cells
     *
     * @return Cell|null
     */
    protected function getCenterCellIfFree(Collection $cells): ?Cell
    {
        return $cells->whereIn('location', $this->centerCell)->filter->isEmpty()->first();
    }
}
