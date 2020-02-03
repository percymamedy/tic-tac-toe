<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

class EmptySideStrategy extends BaseStrategy
{
    /**
     * Sides that can be played.
     *
     * @var array
     */
    protected $sides = [
        'A2',
        'B3',
        'C2',
        'B1',
    ];

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
        return optional($this->findFirstFree($cells, $this->sides))->location;
    }
}
