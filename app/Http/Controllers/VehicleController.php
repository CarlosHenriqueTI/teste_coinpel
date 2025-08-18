<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate,' . $vehicle->id,
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Veículo atualizado com sucesso.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Veículo excluído com sucesso.');
    }
}