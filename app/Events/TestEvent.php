<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('test');
    }

    public function broadcastAs()
    {
        return 'test.fired';
    }

    public function broadcastWith()
    {
        return ['message' => 'This is a test event'];
    }
}
