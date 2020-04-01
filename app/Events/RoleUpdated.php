<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Spatie\Permission\Models\Role;

class RoleUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $role;
    public $old;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Role $role, $old)
    {
        $this->role = $role;
        $this->old = $old;
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
