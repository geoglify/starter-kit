<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Jobs\SaveShipJob;
use App\Events\BroadcastShipPositionUpdate;

class RedisSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to all Redis channels';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Redis::subscribe(['ais_message'], function (string $message) {

            echo "Received message: $message\n";

            $shipData = json_decode($message, true);

            // Validate the message
            if (!isset($shipData['mmsi'])) {
                echo "Invalid message\n";
                return;
            }

            SaveShipJob::dispatch($shipData);

            echo "Ship data saved\n";

            // Convert geojson to JSON string
            $geojsonString = json_encode($shipData['geojson']);

            BroadcastShipPositionUpdate::dispatch($shipData['mmsi'], $shipData['name'], $shipData['cog'], $shipData['sog'], $shipData['hdg'], $shipData['utc'], $shipData['eta'], $shipData['destination'], $geojsonString);

            echo "Ship position broadcasted\n";
        });
    }
}
