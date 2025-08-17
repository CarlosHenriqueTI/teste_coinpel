use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    // ... outras rotas do Breeze
    Route::resource('drivers', DriverController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('trips', TripController::class);
    Route::resource('users', UserController::class);
});