<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Mensagem;
use App\Models\UserTenant;

class EnviarMensagem implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $mensagem;
    private $usr;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Mensagem $mensagem, UserTenant $usr)
    {
        $this->usr = $usr;
        $this->mensagem = $mensagem;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        \Log::info('broadcastOn - '.  $this->usr->id);
        return new PrivateChannel('mensagem-recebida.'. $this->usr->id);
    }

    public function broadcastWith() {

        return $this->mensagem->toArray();

    }
}
