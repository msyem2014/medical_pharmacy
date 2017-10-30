<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationCount implements  ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $count,$user;

    /**
     * Create a new event instance.
     *
     * @param $count
     * @param $user
     */
    public function __construct($count,$user)
    {
        $this->count = $count;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications-count-get'.$this->user->id];
    }

    public function broadcastAs()
    {
        return 'notifications.count.get';
    }
}
