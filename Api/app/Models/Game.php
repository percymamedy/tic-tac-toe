<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Game extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'completed_at',
    ];

    /**
     * New up cells for the game.
     *
     * @param Collection $cells
     *
     * @return Game
     */
    public function newUpCells(Collection $cells): Game
    {
        return tap($this, function (Game $game) use ($cells) {
            $game->cells()->createMany($cells->transform(function (string $cell) {
                return ['location' => $cell];
            }));
        });
    }

    /**
     * Set the cell location to the given value in the current game.
     *
     * @param string $value
     * @param string $location
     *
     * @return Game
     */
    public function play(string $value, string $location): Game
    {
        $this->cells()->where('location', $location)->update([
            'value' => $value,
        ]);

        return $this;
    }

    /**
     * Mark the game as un completed.
     *
     * @return Game
     */
    public function markAsUnCompleted(): Game
    {
        $this->completed_at = null;

        return $this;
    }

    /**
     * Checks if the current game has the given cell.
     *
     * @param Cell $cell
     *
     * @return bool
     */
    public function contains(Cell $cell): bool
    {
        return $this->cells->pluck('id')->contains($cell->id);
    }

    /**
     * Reset all the cells in the Game to their
     * initial value.
     *
     * @return Game
     */
    public function resetAllCells(): Game
    {
        return tap($this, function (Game $game) {
            $game->cells()
                 ->update([
                     'value' => null,
                 ]);
        });
    }

    /**
     * The cells which the game compromises of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cells()
    {
        return $this->hasMany(Cell::class);
    }
}
