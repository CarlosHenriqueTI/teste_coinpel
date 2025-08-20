<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar drivers de teste
        $driver1 = Driver::firstOrCreate([
            'name' => 'Carlos Vinícius',
        ], [
            'cpf' => '12548793001'
        ]);

        $driver2 = Driver::firstOrCreate([
            'name' => 'Maria Silva',
        ], [
            'cpf' => '98765432001'
        ]);

        // Criar veículos de teste
        $vehicle1 = Vehicle::firstOrCreate([
            'plate' => 'ABC-1234',
        ], [
            'model' => 'Scania',
            'brand' => 'Scania'
        ]);

        $vehicle2 = Vehicle::firstOrCreate([
            'plate' => 'XYZ-5678',
        ], [
            'model' => 'Mercedes-Benz',
            'brand' => 'Mercedes'
        ]);

        // Criar trips de teste
        Trip::firstOrCreate([
            'origin' => 'Pelotas',
            'destination' => 'Gramado',
        ], [
            'driver_id' => $driver1->id,
            'vehicle_id' => $vehicle1->id,
            'departure_time' => '2025-08-20 15:00:00',
            'arrival_time' => '2025-08-20 18:00:00',
            'status' => 'in_progress',
            'price' => 40.00,
            'passenger_count' => 35,
            'trip_name' => 'ChocoFest',
            'rule' => 'Turismo',
            'ticket_price' => 'R$ 40,00',
            'driver_registration' => '12548793'
        ]);

        Trip::firstOrCreate([
            'origin' => 'Porto Alegre',
            'destination' => 'Canela',
        ], [
            'driver_id' => $driver2->id,
            'vehicle_id' => $vehicle2->id,
            'departure_time' => '2025-08-21 08:00:00',
            'arrival_time' => '2025-08-21 11:00:00',
            'status' => 'completed',
            'price' => 35.00,
            'passenger_count' => 40,
            'trip_name' => 'Excursão Canela',
            'rule' => 'Turismo',
            'ticket_price' => 'R$ 35,00',
            'driver_registration' => '98765432'
        ]);
    }
}
