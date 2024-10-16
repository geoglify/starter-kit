<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastShipPositionUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $mmsi,
        public ?string $name,
        public ?float $cog,
        public ?float $sog,
        public ?int $hdg,
        public ?string $utc,
        public ?string $eta,
        public ?string $destination,
        public ?string $geojson
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('realtime_ships');
    }

    public function broadcastWith(): array
    {
        return [
            'mmsi' => $this->mmsi,
            'name' => $this->name,
            'cog' => $this->cog,
            'sog' => $this->sog,
            'hdg' => $this->hdg,
            'utc' => $this->utc,
            'eta' => $this->eta,
            'destination' => $this->destination,
            'geojson' => $this->geojson
        ];
    }
}
