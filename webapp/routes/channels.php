<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ais', function ($message) {
    return $message;
});