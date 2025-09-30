<?php
// app/Events/QueueUpdated.php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Queue;

class QueueUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue->load('patient');
    }

    public function broadcastOn()
    {
        return new Channel('queue-updates');
    }

    public function broadcastAs()
    {
        return 'queue.updated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->queue->id,
            'patient_name' => $this->queue->patient->name,
            'queue_number' => $this->queue->queue_number,
            'status' => $this->queue->status,
            'called_at' => $this->queue->called_at,
            'completed_at' => $this->queue->completed_at,
        ];
    }
}