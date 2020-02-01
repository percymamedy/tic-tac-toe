<?php

namespace App\Repositories;

use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="App\Models\Game")
 * \@mixin \App\Models\Game
 */
class Games extends EloquentRepository
{
    //
}
