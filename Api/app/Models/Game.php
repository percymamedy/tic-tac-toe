<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

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
