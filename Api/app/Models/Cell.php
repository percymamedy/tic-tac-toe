<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cell extends Model
{
    use SoftDeletes;

    /**
     * Update the value of the cell.
     *
     * @param mixed $value
     *
     * @return Cell
     */
    public function updateValue($value): Cell
    {
        $this->value = $value;

        return $this;
    }

    /**
     * The game to which this cell belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
