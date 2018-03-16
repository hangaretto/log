<?php namespace Magnetar\Log\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Event;

class MagnetarLogEvent extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $template;
    public $code;
    public $level;
    public $user_id;
    public $category = 'default';

    public $created_at;
    public $updated_at;

    /**
     * MagnetarLogEvent constructor.
     *
     * @param string $template
     * @param string $code
     * @param string $level
     * @param int $user_id
     */
    public function __construct($template, $code, $level, $user_id)
    {
        $this->template = $template;
        $this->code = $code;
        $this->level = $level;
        $this->user_id = $user_id;

        $this->updated_at = $this->created_at = Carbon::now()->toDateTimeString();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('magnetar_log_notification');
    }
}
