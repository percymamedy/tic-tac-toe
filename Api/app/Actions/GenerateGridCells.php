<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use Spatie\QueueableAction\QueueableAction;

class GenerateGridCells
{
    use QueueableAction;

    /**
     * Execute the action.
     *
     * @param int $grid
     *
     * @return mixed
     */
    public function execute(int $grid): Collection
    {
        $cells = collect([]);

        foreach ($this->rows($grid) as $row) {
            foreach ($this->columns($grid) as $column) {
                $cells->push($row . $column);
            }
        }

        return $cells;
    }

    /**
     * Get the grid rows.
     *
     * @param int $number
     *
     * @return array
     */
    protected function rows(int $number): array
    {
        return collect(range('A', 'Z'))->splice(0, $number)->all();
    }

    /**
     * Get the grid columns.
     *
     * @param int $number
     *
     * @return array
     */
    protected function columns(int $number): array
    {
        return range(1, $number);
    }
}
