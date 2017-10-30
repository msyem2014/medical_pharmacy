<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notifications implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;


    public $notification = [] ;
    public $notifier ;

    /**
     * Create a new event instance.
     *
     * @param $notification
     */
    public function __construct($notification)
    {
        $this->notifier = $notification->notifier;
         array_push($this->notification , $notification);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications-'.$this->notifier];
    }

    public function broadcastAs()
    {
        return 'notifications.get';
    }

}
