<?php

namespace App\Events;

class GameWonByPlayer extends GameEvent
{
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'game.won_by_player';
    }
}
