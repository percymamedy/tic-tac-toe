<?php

namespace App\Events;

use App\Models\Cell;
use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MovePlayed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The game which is being played.
     *
     * @var Game
     */
    protected $game;

    /**
     * The cell which was moved.
     *
     * @var Cell
     */
    protected $cell;

    /**
     * MovePlayed constructor.
     *
     * @param Game $game
     * @param Cell $cell
     */
    public function __construct(Game $game, Cell $cell = null)
    {
        $this->game = $game;
        $this->cell = $cell;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('games.' . $this->game->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        if (!is_null($this->cell)) {
            return $this->cell->toArray();
        }

        return [];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'game.move_played';
    }
}
