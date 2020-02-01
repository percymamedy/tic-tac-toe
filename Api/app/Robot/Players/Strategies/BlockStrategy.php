<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

class BlockStrategy extends BaseStrategy
{
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
        foreach ($this->calculateWinningCombinations() as $combination) {
            $combinationCells = $this->combinationCells($cells, $combination);

            if ($this->cannotLeadToSuccess($combinationCells)) {
                continue;
            }

            if ($this->cellsAreFilledWithPeice($combinationCells, $opponentPiece)) {
                return $this->findMissingPiece($combinationCells)->location;
            }
        }

        return null;
    }
}
