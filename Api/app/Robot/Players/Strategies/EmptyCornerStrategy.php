<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

class EmptyCornerStrategy extends BaseStrategy
{
    /**
     * Corners that can be played.
     *
     * @var array
     */
    protected $corners = [
        'A1',
        'C1',
        'C3',
        'A3',
    ];

    /**
     * Find the move within the given cells.
     *
     * @param Collection $cells
     * @param string     $peice
     * @param string     $opponentPiece
     *
     * @return null|string
     */
    public function findMove(Collection $cells, string $peice, string $opponentPiece): ?string
    {
        return optional($this->findFirstFree($cells, $this->corners))->location;
    }
}
