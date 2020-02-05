<?php

namespace App\Robot\Players\Strategies;

use App\Concerns\Forkable;
use Illuminate\Support\Collection;

class ForkStrategy extends BaseStrategy
{
    use Forkable;

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
        return $this->findForkOn($cells, $piece);
    }
}
