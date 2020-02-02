<?php

namespace Tests\Feature;

use App\Enums\CellValue;
use App\Models\Cell;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test we can creat a new game.
     *
     * @return void
     */
    public function test_it_creates_a_new_game()
    {
        $response = $this->postJson(route('api.games.store'), ['grid' => 3]);

        $response->assertSuccessful();

        $this->assertEquals(1, Game::count());
        $this->assertEquals(9, Cell::count());
    }

    /**
     * Test we can reset a game.
     *
     * @return void
     */
    public function test_it_resets_a_game()
    {
        $game = factory(Game::class)->create();

        factory(Cell::class, 9)->create([
            'game_id' => $game->id,
        ]);

        $response = $this->putJson(route('api.games.reset', $game));

        $response->assertSuccessful();

        $this->assertDatabaseHas('games', [
            'id'           => $game->id,
            'completed_at' => null,
        ]);

        $this->assertDatabaseHas('cells', [
            'game_id' => $game->id,
            'value'   => null,
        ]);
    }

    /**
     * Test that we are able to save the next move of the player.
     *
     * @return void
     */
    public function test_play_saves_next_move()
    {
        $game = factory(Game::class)->create();
        $cell = factory(Cell::class)->create([
            'game_id'  => $game->id,
            'value'    => null,
            'location' => 'A1',
        ]);

        factory(Cell::class)->create([
            'game_id'  => $game->id,
            'value'    => null,
            'location' => 'A2',
        ]);

        $response = $this->putJson(
            route('api.games.cells.update', ['game' => $game, 'cell' => $cell]),
            ['value' => CellValue::O, 'opponent' => CellValue::X]
        );

        $response->assertSuccessful();

        $this->assertDatabaseHas('cells', [
            'id'       => $cell->id,
            'location' => $cell->location,
            'value'    => CellValue::O,
        ]);
    }
}
