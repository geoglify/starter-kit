<?php

namespace App\Http\Controllers;

use App\Models\ShipRealtimePosition;
use App\Models\Ship;
use Illuminate\Http\Request;

class ShipRealtimePositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // 
    }


    /**
     * Display the specified resource.
     */
    public function show(ShipRealtimePosition $ship_realtime_positions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipRealtimePosition $ship_realtime_positions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShipRealtimePosition $ship_realtime_position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipRealtimePosition $ship_realtime_position)
    {
        //
    }

    public function list(Request $request)
    {
        
        $ship_realtime_positions = ShipRealtimePosition::all();

        foreach($ship_realtime_positions as $ship_realtime_position) 
        {
            $ship = Ship::where('mmsi', $ship_realtime_position->mmsi)->first();
            $ship_realtime_position->name = $ship->name;
            $ship_realtime_position->cargo = (int) $ship->cargo;
            $ship_realtime_position->callsign = $ship->callsign;
            $ship_realtime_position->dimA = $ship->dimA;
            $ship_realtime_position->dimB = $ship->dimB;
            $ship_realtime_position->dimC = $ship->dimC;
            $ship_realtime_position->dimD = $ship->dimD;
        }

        return response()->json($ship_realtime_positions);
    }
}
