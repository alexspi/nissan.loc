<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.08.2016
 * Time: 16:14
 */

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShippingStatusUpdated implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new PrivateChannel('order.'.$this->update->order_id);
    }
}