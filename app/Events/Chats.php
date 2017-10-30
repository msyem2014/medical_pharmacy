<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class Chats implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $chats = [];
    public $user;

    /**
     * Create a new event instance.
     *
     * @param $chats
     */
    public function __construct($chats,$user)
    {
        foreach ($chats as $chat){
            array_push($this->chats, $chat);
        }
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['chats-'.$this->user->id];
    }

    public function broadcastAs()
    {
        return 'chats.get';
    }
}
