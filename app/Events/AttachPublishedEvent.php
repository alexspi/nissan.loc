<?php

namespace App\Events;

use App\Models\UserAttach;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttachPublishedEvent extends Event
{
    use InteractsWithSockets, SerializesModels;

    public $userattach;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserAttach $userattach)
    {
        $this->UserAttach = $userattach;

      //  dd($userattach);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
