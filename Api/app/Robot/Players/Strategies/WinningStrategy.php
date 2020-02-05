<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

class WinningStrategy extends BaseStrategy
{
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
        foreach ($this->calculateWinningCombinations() as $combination) {
            $combinationCells = $this->combinationCells($cells, $combination);

            if ($this->cannotLeadToSuccess($combinationCells)) {
                continue;
            }

            if ($this->cellsAreFilledWithPeice($combinationCells, $piece)) {
                return $this->findMissingPiece($combinationCells)->location;
            }
        }

        return null;
    }
}
