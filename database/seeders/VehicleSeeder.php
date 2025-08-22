<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar veículos existentes
        $vehicle1 = Vehicle::where('plate', 'ABC-1234')->first();
        if ($vehicle1) {
            $vehicle1->update([
                'prefix' => '202',
                'chassis' => 'IVS-2622',
                'type' => 'Ônibus',
                'capacity' => 45,
                'year' => 2006,
                'features' => ['Internet', 'WC', 'Ar Condicionado']
            ]);
        }

        $vehicle2 = Vehicle::where('plate', 'XYZ-5678')->first();
        if ($vehicle2) {
            $vehicle2->update([
                'prefix' => '203',
                'chassis' => 'IVS-2623',
                'type' => 'Ônibus',
                'capacity' => 45,
                'year' => 2007,
                'features' => ['WC', 'Ar Condicionado', 'Vídeo']
            ]);
        }

        // Criar novos veículos se não existirem
        Vehicle::firstOrCreate([
            'plate' => 'DEF-9012',
        ], [
            'prefix' => '204',
            'model' => 'Scania',
            'brand' => 'Marcopolo',
            'chassis' => 'IVS-2624',
            'type' => 'Ônibus',
            'capacity' => 45,
            'year' => 2008,
            'features' => ['Internet', 'Tomada', 'Geladeira', 'Vídeo']
        ]);

        Vehicle::firstOrCreate([
            'plate' => 'GHI-3456',
        ], [
            'prefix' => '205',
            'model' => 'Scania',
            'brand' => 'Marcopolo',
            'chassis' => 'IVS-2625',
            'type' => 'Van',
            'capacity' => 15,
            'year' => 2009,
            'features' => ['Ar Condicionado', 'Tomada']
        ]);

        Vehicle::firstOrCreate([
            'plate' => 'JKL-7890',
        ], [
            'prefix' => '206',
            'model' => 'Scania',
            'brand' => 'Marcopolo',
            'chassis' => 'IVS-2626',
            'type' => 'Ônibus',
            'capacity' => 45,
            'year' => 2010,
            'features' => ['Internet', 'WC', 'Ar Condicionado', 'Geladeira', 'Calefação', 'Vídeo']
        ]);
    }
}
