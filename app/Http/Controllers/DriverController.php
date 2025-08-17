<?php
namespace App\Http\Controllers;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller {
    public function index() {
        $drivers = Driver::latest()->paginate(10);
        return view('drivers.index', compact('drivers'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:drivers,cpf',
        ]);
        Driver::create($validated);
        return redirect()->route('drivers.index')->with('success', 'Motorista cadastrado com sucesso.');
    }

    public function update(Request $request, Driver $driver) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:drivers,cpf,' . $driver->id,
        ]);
        $driver->update($validated);
        return redirect()->route('drivers.index')->with('success', 'Motorista atualizado com sucesso.');
    }

    public function destroy(Driver $driver) {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Motorista excluído com sucesso.');
    }
}