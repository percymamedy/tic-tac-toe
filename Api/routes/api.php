<?php

use App\Http\Controllers;

// Games Group.
Route::prefix('games')->group(function () {

    // Start a new game.
    Route::post('store', [Controllers\GameController::class, 'store'])
         ->name('api.games.store');

    // Fetch game.
    Route::get('{game}', [Controllers\GameController::class, 'show'])
         ->name('api.games.show');

    // Reset a game.
    Route::put('{game}/reset', [Controllers\GameController::class, 'reset'])
         ->name('api.games.reset');

    // Update cell value.
    Route::put('{game}/cells/{cell}', Controllers\GameCellController::class)
         ->name('api.games.cells.update');
});
