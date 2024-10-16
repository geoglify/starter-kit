<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Ship;
use App\Models\ShipRealtimePosition;
use App\Models\ShipHistoricalPosition;

class SaveShipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ship;

    /**
     * Create a new job instance.
     */
    public function __construct($ship)
    {
        $this->ship = $ship;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Atualiza o navio apenas se os valores não forem vazios ou null
        Ship::updateOrCreate(
            ['mmsi' => $this->ship['mmsi']],
            array_filter([
                'name' => $this->ship['name'] ?? null,
                'dimA' => $this->ship['dimA'] ?? null,
                'dimB' => $this->ship['dimB'] ?? null,
                'dimC' => $this->ship['dimC'] ?? null,
                'dimD' => $this->ship['dimD'] ?? null,
                'imo' => $this->ship['imo'] ?? null,
                'callsign' => $this->ship['callsign'] ?? null,
                'draught' => $this->ship['draught'] ?? null,
                'cargo' => $this->ship['cargo'] ?? null,
            ], function ($value) {
                return !is_null($value) && $value !== '';
            })
        );

        // Atualiza ou cria a posição em tempo real
        ShipRealtimePosition::updateOrCreate(
            ['mmsi' => $this->ship['mmsi']],
            [
                'cog' => $this->ship['cog'] ?? null,
                'sog' => $this->ship['sog'] ?? null,
                'hdg' => $this->ship['hdg'] ?? null,
                'utc' => $this->ship['utc'] ?? now(),
                'eta' => $this->ship['eta'] ?? null,
                'destination' => $this->ship['destination'] ?? null,
                'geojson' => json_encode($this->ship['geojson']),
            ]
        );

        // Cria uma nova posição histórica
        ShipHistoricalPosition::create([
            'mmsi' => $this->ship['mmsi'],
            'cog' => $this->ship['cog'] ?? null,
            'sog' => $this->ship['sog'] ?? null,
            'hdg' => $this->ship['hdg'] ?? null,
            'utc' => $this->ship['utc'] ?? now(),
            'eta' => $this->ship['eta'] ?? null,
            'destination' => $this->ship['destination'] ?? null,
            'geojson' => json_encode($this->ship['geojson']),
        ]);
    }
}
