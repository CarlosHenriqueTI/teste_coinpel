<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Página inicial mostra loading e depois redireciona para login
Route::get('/', function () {
    return view('loading');
});

// Dashboard redireciona para lista de usuários
Route::get('/dashboard', function () {
    return redirect()->route('users.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'force.password.change'])->group(function () {
    // Rotas do Perfil (geradas pelo Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rota para mudança obrigatória de senha
    Route::get('/change-password', function () {
        return view('auth.change-password');
    })->name('change-password');
    
    // Rotas de recursos para os seus CRUDs
    Route::resource('drivers', DriverController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('trips', TripController::class);
    Route::get('/trips/{trip}/details', [TripController::class, 'show'])->name('trips.details');
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
