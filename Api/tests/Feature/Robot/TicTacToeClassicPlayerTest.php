<?php

namespace Tests\Feature\Robot;

use App\Enums\CellValue;
use App\Models\Game;
use App\Robot\Contracts\Player;
use App\Robot\Players\Strategies;
use Facades\App\Actions\GenerateGridCells;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicTacToeClassicPlayerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the player can check for and win then next
     * move.
     *
     * @return void
     */
    public function test_it_can_win()
    {
        $player = resolve(Player::class);
        $player->loadStrategies(collect([
            resolve(Strategies\WinningStrategy::class),
        ]));

        $game1 = factory(Game::class)->create();
        $game1->newUpCells(GenerateGridCells::execute(3));

        $game1->play(CellValue::X, 'A1');
        $game1->play(CellValue::X, 'A3');

        $winMove1 = $player->nextMoveIn($game1, CellValue::X, CellValue::O);
        $this->assertEquals('A2', $winMove1);

        $game2 = factory(Game::class)->create();
        $game2->newUpCells(GenerateGridCells::execute(3));

        $game2->play(CellValue::X, 'A2');
        $game2->play(CellValue::X, 'B2');

        $winMove2 = $player->nextMoveIn($game2, CellValue::X, CellValue::O);
        $this->assertEquals('C2', $winMove2);

        $game3 = factory(Game::class)->create();
        $game3->newUpCells(GenerateGridCells::execute(3));

        $game3->play(CellValue::X, 'A3');
        $game3->play(CellValue::X, 'C1');

        $winMove3 = $player->nextMoveIn($game3, CellValue::X, CellValue::O);
        $this->assertEquals('B2', $winMove3);
    }

    /**
     * Test that we can block the opponent player when he has 2 moves
     * in a row.
     *
     * @return void
     */
    public function test_it_can_block()
    {
        $player = resolve(Player::class);
        $player->loadStrategies(collect([
            resolve(Strategies\BlockStrategy::class),
        ]));

        $game1 = factory(Game::class)->create();
        $game1->newUpCells(GenerateGridCells::execute(3));

        $game1->play(CellValue::O, 'A1');
        $game1->play(CellValue::O, 'A3');

        $winMove1 = $player->nextMoveIn($game1, CellValue::X, CellValue::O);
        $this->assertEquals('A2', $winMove1);

        $game2 = factory(Game::class)->create();
        $game2->newUpCells(GenerateGridCells::execute(3));

        $game2->play(CellValue::O, 'A2');
        $game2->play(CellValue::O, 'B2');

        $winMove2 = $player->nextMoveIn($game2, CellValue::X, CellValue::O);
        $this->assertEquals('C2', $winMove2);

        $game3 = factory(Game::class)->create();
        $game3->newUpCells(GenerateGridCells::execute(3));

        $game3->play(CellValue::O, 'A3');
        $game3->play(CellValue::O, 'C1');

        $winMove3 = $player->nextMoveIn($game3, CellValue::X, CellValue::O);
        $this->assertEquals('B2', $winMove3);
    }

    /**
     * Test we can play on an empty side.
     *
     * @return void
     */
    public function test_it_can_play_an_empty_side()
    {
        $player = resolve(Player::class);
        $player->loadStrategies(collect([
            resolve(Strategies\EmptySideStrategy::class),
        ]));

        $game = factory(Game::class)->create();
        $game->newUpCells(GenerateGridCells::execute(3));

        $game->play(CellValue::O, 'A2');
        $game->play(CellValue::O, 'B3');
        $game->play(CellValue::O, 'C2');

        $move = $player->nextMoveIn($game, CellValue::X, CellValue::O);
        $this->assertEquals('B1', $move);
    }
}
