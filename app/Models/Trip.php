<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model {
    use HasFactory;
    protected $fillable = ['driver_id', 'vehicle_id', 'origin', 'destination', 'departure_time', 'arrival_time'];

    public function driver(): BelongsTo {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo {
        return $this->belongsTo(Vehicle::class);
    }
}