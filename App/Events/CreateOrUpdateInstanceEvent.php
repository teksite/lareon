<?php

namespace Lareon\CMS\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Lareon\CMS\App\Enums\ActionTypesEnum;
use Lareon\Modules\Seo\App\Interfaces\ActionTypeInterface;

class CreateOrUpdateInstanceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Model $instance, public array $data = [], public ActionTypesEnum $type = ActionTypesEnum::NEW)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
