<?php

namespace Tests\Feature\Robot;

use App\Enums\CellValue;
use App\Models\Game;
use App\Robot\Contracts\Player;
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
        $game1 = factory(Game::class)->create();
        $game1->newUpCells(GenerateGridCells::execute(3));

        $game1->play(CellValue::X, 'A1');
        $game1->play(CellValue::X, 'A3');

        $winMove1 = resolve(Player::class)->nextMoveIn($game1, CellValue::X);
        $this->assertEquals('A2', $winMove1);

        $game2 = factory(Game::class)->create();
        $game2->newUpCells(GenerateGridCells::execute(3));

        $game2->play(CellValue::X, 'A2');
        $game2->play(CellValue::X, 'B2');

        $winMove2 = resolve(Player::class)->nextMoveIn($game2, CellValue::X);
        $this->assertEquals('C2', $winMove2);

        $game3 = factory(Game::class)->create();
        $game3->newUpCells(GenerateGridCells::execute(3));

        $game3->play(CellValue::X, 'A3');
        $game3->play(CellValue::X, 'C1');

        $winMove3 = resolve(Player::class)->nextMoveIn($game3, CellValue::X);
        $this->assertEquals('B2', $winMove3);
    }
}
