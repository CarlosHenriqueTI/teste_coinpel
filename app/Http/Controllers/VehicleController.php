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
            'prefix' => 'nullable|string|max:10',
            'plate' => 'required|string|max:10|unique:vehicles,plate',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'chassis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1|max:100',
            'year' => 'nullable|integer|min:1900|max:2030',
            'features' => 'nullable|array',
            'features.*' => 'string|in:Internet,WC,Tomada,Ar Condicionado,Geladeira,Calefação,Vídeo',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'prefix' => 'nullable|string|max:10',
            'plate' => 'required|string|max:10|unique:vehicles,plate,' . $vehicle->id,
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'chassis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1|max:100',
            'year' => 'nullable|integer|min:1900|max:2030',
            'features' => 'nullable|array',
            'features.*' => 'string|in:Internet,WC,Tomada,Ar Condicionado,Geladeira,Calefação,Vídeo',
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