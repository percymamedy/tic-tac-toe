<?php

namespace App\Events;

class GameDraw extends GameEvent
{
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'game.draw';
    }
}
