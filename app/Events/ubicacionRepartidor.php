<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ubicacionRepartidor implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pedido_id;
    public $ubicacion;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pedido_id, $ubicacion)
    {
        $this->pedido_id = $pedido_id;
        $this->ubicacion = $ubicacion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('UbicacionRepartidorChannel'.$this->pedido_id);
    }
}
