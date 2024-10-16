<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\RealtimePositionJanitorJob;

// Schedule the RealtimePositionJanitorJob command to run every minute
Schedule::job(new RealtimePositionJanitorJob)->everyMinute();