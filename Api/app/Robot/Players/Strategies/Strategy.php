<?php

namespace App\Robot\Players\Strategies;

use Illuminate\Support\Collection;

interface Strategy
{
    /**
     * Find the move within the given cells.
     *
     * @param Collection $cells
     * @param string     $peice
     *
     * @return null|string
     */
    public function findMove(Collection $cells, string $peice): ?string;
}
