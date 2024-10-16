<?php

namespace App\Http\Controllers;

use App\Models\ShipHistoricalPosition;
use Illuminate\Http\Request;

class ShipHistoricalPositionController extends Controller
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
    public function show(ShipHistoricalPosition $ship_historical_position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipHistoricalPosition $ship_historical_position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShipHistoricalPosition $ship_historical_position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipHistoricalPosition $ship_historical_position)
    {
        //
    }

    public function list(Request $request)
    {
        $ship_historical_positions = ShipHistoricalPosition::all();    
        return response()->json($ship_historical_positions);
    }
}