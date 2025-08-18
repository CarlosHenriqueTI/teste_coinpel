<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['driver', 'vehicle'])->latest()->paginate(10);
        return view('trips.index', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after_or_equal:departure_time',
        ]);

        Trip::create($validated);

        return redirect()->route('trips.index')->with('success', 'Viagem cadastrada com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after_or_equal:departure_time',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.index')->with('success', 'Viagem atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Viagem excluída com sucesso.');
    }
}