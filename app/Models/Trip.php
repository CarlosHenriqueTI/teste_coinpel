<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model {
    use HasFactory;
    protected $fillable = [
        'driver_id', 
        'vehicle_id', 
        'origin', 
        'destination', 
        'departure_time', 
        'arrival_time',
        'status',
        'price',
        'category',
        'passenger_count',
        'trip_name',
        'rule',
        'trip_date',
        'ticket_price',
        'driver_registration'
    ];

    protected $attributes = [
        'status' => 'in_progress',
    ];

    public function driver(): BelongsTo {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo {
        return $this->belongsTo(Vehicle::class);
    }
}