<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // ini penting
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketMessage implements ShouldBroadcast // ini penting juga
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function broadcastOn()
    {
        return  new Channel('received-ticket-'. $this->ticket['id'] ) // channel publik
        ;

       
    }

    public function broadcastAs()
    {
        return 'message-received';
    }
}
