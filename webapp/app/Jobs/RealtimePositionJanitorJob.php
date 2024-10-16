<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\ShipRealtimePosition;
use Carbon\Carbon;

/* 
 * This job is responsible for cleaning up the ShipRealtimePosition table.
 * It will remove all ships that are older than 30 minutes.
 */
class RealtimePositionJanitorJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the threshold time
        $threshold = Carbon::now()->subMinutes(30);

        // Get all ships that are older than the threshold
        $shipsToRemove = ShipRealtimePosition::where('utc', '<=', $threshold)->get();

        foreach ($shipsToRemove as $ship) {
            // Delete the ship
            $ship->delete();
        }
    }
}
