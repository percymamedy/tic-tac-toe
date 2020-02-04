<?php

namespace App\Concerns;

use Illuminate\Support\Collection;

trait Forkable
{
    /**
     * The rules for successful forking.
     *
     * @var array
     */
    protected $forks = [
        'A1' => [
            [
                'filled' => ['C1', 'A3'],
                'empty'  => ['A1', 'A2', 'B1'],
            ],
            [
                'filled' => ['B1', 'B2'],
                'empty'  => ['A1', 'C1', 'C3'],
            ],
            [
                'filled' => ['B2', 'C1'],
                'empty'  => ['A1', 'B1', 'A3'],
            ],
            [
                'filled' => ['B2', 'A3'],
                'empty'  => ['A1', 'A2', 'C3'],
            ],
        ],

        'C3' => [
            [
                'filled' => ['C1', 'A3'],
                'empty'  => ['C3', 'C2', 'B3'],
            ],
            [
                'filled' => ['B2', 'C1'],
                'empty'  => ['C3', 'C2', 'A1'],
            ],
            [
                'filled' => ['B2', 'A3'],
                'empty'  => ['C3', 'B3', 'A1'],
            ],
        ],

        'C1' => [
            [
                'filled' => ['A1', 'C3'],
                'empty'  => ['C1', 'C2', 'B1'],
            ],
            [
                'filled' => ['A1', 'B2'],
                'empty'  => ['C1', 'B1', 'A3'],
            ],
            [
                'filled' => ['B1', 'B2'],
                'empty'  => ['C1', 'A3', 'A1'],
            ],
            [
                'filled' => ['B2', 'C3'],
                'empty'  => ['C1', 'C2', 'A3'],
            ],
        ],

        'A3' => [
            [
                'filled' => ['A1', 'C3'],
                'empty'  => ['A3', 'B3', 'A2'],
            ],
            [
                'filled' => ['A1', 'B2'],
                'empty'  => ['A3', 'C1', 'A2'],
            ],
            [
                'filled' => ['B2', 'C3'],
                'empty'  => ['A3', 'B3', 'C1'],
            ],
        ],
    ];

    /**
     * Checks if any of the fork conditions is true.
     *
     * @param Collection $cells
     * @param string     $piece
     * @param array      $conditions
     *
     * @return bool
     */
    public function hasAnyforkConditions(Collection $cells, string $piece, array $conditions): bool
    {
        return !is_null(collect($conditions)->first(function (array $condition) use ($cells, $piece) {
            return $this->conditionStatisfied($condition, $cells, $piece);
        }));
    }

    /**
     * Calculate possible forks.
     *
     * @return array
     */
    public function calculateForks(): array
    {
        return $this->forks;
    }

    /**
     * Checks if the condition is satisfied.
     *
     * @param array      $condition
     * @param Collection $cells
     * @param string     $piece
     *
     * @return bool
     */
    protected function conditionStatisfied(array $condition, Collection $cells, string $piece): bool
    {
        return (
            $cells->whereIn('location', $condition['filled'])->filter->isFilledWith($piece)->count() === count($condition['filled']) &&
            $cells->whereIn('location', $condition['empty'])->filter->isEmpty()->count() === count($condition['empty'])
        );
    }
}
