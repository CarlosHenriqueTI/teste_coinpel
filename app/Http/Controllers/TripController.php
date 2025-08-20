<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['driver', 'vehicle']);

        // Implementar pesquisa flexível
        if ($search = $request->get('search')) {
            // Normalizar string de pesquisa (remover acentos e converter para minúsculas)
            $normalizedSearch = $this->normalizeString($search);
            
            $query->where(function($q) use ($search, $normalizedSearch) {
                // Pesquisa em campos da própria trip
                $q->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(origin, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%'])
                  ->orWhereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(destination, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%'])
                  
                  // Pesquisa no nome do motorista
                  ->orWhereHas('driver', function($driverQuery) use ($search, $normalizedSearch) {
                      $driverQuery->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%']);
                  })
                  
                  // Pesquisa no modelo, marca ou placa do veículo
                  ->orWhereHas('vehicle', function($vehicleQuery) use ($search, $normalizedSearch) {
                      $vehicleQuery->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(model, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%'])
                                ->orWhereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(brand, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%'])
                                ->orWhereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(plate, "á", "a"), "à", "a"), "ã", "a"), "â", "a"), "é", "e"), "ê", "e"), "í", "i"), "ó", "o"), "ô", "o"), "ú", "u")) LIKE ?', ['%' . $normalizedSearch . '%']);
                  });
            });
        }

        $trips = $query->latest('departure_time')->paginate(10);
        
        // Preservar parâmetros de pesquisa na paginação
        $trips->appends($request->query());

        return view('trips.index', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_name' => 'required|string|max:255',
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after_or_equal:departure_time',
        ]);

        // Adiciona status padrão se não fornecido
        $validated['status'] = 'in_progress';

        Trip::create($validated);

        return redirect()->route('trips.index')->with('success', 'Viagem cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle']);
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        
        return view('trips.show', compact('trip', 'drivers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'trip_name' => 'nullable|string|max:255',
            'rule' => 'nullable|string|max:255',
            'trip_date' => 'nullable|date',
            'departure_time' => 'nullable',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'ticket_price' => 'nullable|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'passenger_count' => 'nullable|integer|min:1',
            'driver_id' => 'nullable|exists:drivers,id',
            'driver_registration' => 'nullable|string|max:255',
            'status' => 'nullable|in:in_progress,completed,cancelled',
        ]);

        // Combinar data e hora se ambos estiverem presentes
        if ($request->trip_date && $request->departure_time) {
            $validated['departure_time'] = $request->trip_date . ' ' . $request->departure_time;
        }

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

    /**
     * Normaliza string removendo acentos e convertendo para minúsculas
     */
    private function normalizeString($string)
    {
        $string = strtolower($string);
        $unwanted_array = array(
            'á'=>'a', 'à'=>'a', 'ã'=>'a', 'â'=>'a', 'ä'=>'a',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e',
            'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i',
            'ó'=>'o', 'ò'=>'o', 'õ'=>'o', 'ô'=>'o', 'ö'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u',
            'ç'=>'c', 'ñ'=>'n'
        );
        return strtr($string, $unwanted_array);
    }
}