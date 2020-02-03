<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the Player contract.
        $this->app->bind(\App\Robot\Contracts\Player::class, function (\Illuminate\Foundation\Application $app) {
            $strategies = collect([
                $app->make(\App\Robot\Players\Strategies\WinningStrategy::class),
                $app->make(\App\Robot\Players\Strategies\BlockStrategy::class),
                $app->make(\App\Robot\Players\Strategies\CenterStrategy::class),
                $app->make(\App\Robot\Players\Strategies\EmptyCornerStrategy::class),
                $app->make(\App\Robot\Players\Strategies\EmptySideStrategy::class),
            ]);

            return new \App\Robot\Players\TicTacToeClassicPlayer($strategies);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
