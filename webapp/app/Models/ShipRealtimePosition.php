<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipRealtimePosition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mmsi',
        'cog',
        'sog',
        'hdg',
        'utc',
        'eta',
        'destination',
        'geojson'
    ];
}
