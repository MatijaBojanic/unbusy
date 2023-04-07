<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class BusLocationUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $busLineId;
    public $busId;

    public $latitude;

    public $longitude;

    public function __construct(int $busLineId, int $busId, float $latitude, float $longitude)
    {
        $this->busLineId = $busLineId;
        $this->busId = $busId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('public.bus-line.'.$this->busLineId.'.location')
        ];
    }

    public function broadcastAs(): string
    {
        return 'bus.location.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'bus_id' => $this->busId,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
}
