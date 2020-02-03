<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

class OppositeCornerStrategy extends BaseStrategy
{
    /**
     * The corners and their opposite sides.
     *
     * @var array
     */
    protected $cornersAndOpposites = [
        'A1' => ['A3', 'C1'],
        'C1' => ['A1', 'C3'],
        'C3' => ['C1', 'A3'],
        'A3' => ['A1', 'C3'],
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
        foreach ($this->getCornersAndOpposites() as $corner => $opposites) {
            // Find the corner cell.
            $cornerCell = $cells->where('location', $corner)->filter->isFilledWith($opponentPiece)->first();
            $firstFreeOpposite = $cells->whereIn('location', $opposites)->filter->isEmpty()->first();

            if (!is_null($cornerCell) && !is_null($firstFreeOpposite)) {
                return $firstFreeOpposite->location;
            }
        }

        return null;
    }

    /**
     * Get all corners and their opposite of them.
     *
     * @return array
     */
    protected function getCornersAndOpposites(): array
    {
        return $this->cornersAndOpposites;
    }
}
