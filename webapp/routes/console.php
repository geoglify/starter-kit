<?php

use App\Console\Commands\ShipsSync;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ShipsSync)->everyMinute();