<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ShipsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ships-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ships data from external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('ShipsSync command started');

        // Fetch data from external API

        // Get the data from the external API

        Log::info('ShipsSync command finished');
    }
}
