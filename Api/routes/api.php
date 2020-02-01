<?php

use App\Http\Controllers;

// Games Group.
Route::prefix('games')->group(function () {

    // Start a new game.
    Route::post('store', [Controllers\GameController::class, 'store'])
         ->name('api.games.store');

    // Reset a game.
    Route::put('{game}/reset', [Controllers\GameController::class, 'reset'])
         ->name('api.games.reset');
});
