<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cell;
use App\Models\Game;
use Faker\Generator as Faker;

$factory->define(Cell::class, function (Faker $faker) {
    return [
        'game_id'  => factory(Game::class)->create()->id,
        'location' => $faker->randomElement(['A1', 'A2', 'A3']),
        'value'    => \App\Enums\CellValue::getRandomValue(),
    ];
});
