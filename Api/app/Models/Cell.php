<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cell extends Model
{
    use SoftDeletes;

    /**
     * Will tell us if a cell is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return is_null($this->value);
    }

    /**
     * Will tell us if a cell is filled or not.
     *
     * @return bool
     */
    public function isFilled(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Will tell us if the value matches the piece.
     *
     * @param string $piece
     *
     * @return bool
     */
    public function isFilledWith(string $piece): bool
    {
        return $this->value == $piece;
    }

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
