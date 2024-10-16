<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mmsi',
        'name',
        'dimA',
        'dimB',
        'dimC',
        'dimD',
        'imo',
        'callsign',
        'draught',
        'cargo'
    ];
}
