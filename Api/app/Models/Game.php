<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

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
