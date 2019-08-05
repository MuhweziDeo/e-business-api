<?php

namespace App\Events;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class Registration extends Registered
{
    use SerializesModels;

    public $name;
    public $email;

    /**
     * Create a new event instance.
     *
     * @param $email
     * @param $name
     */
    public function __construct($email, $name)
    {
        //
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
