<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model {
    use HasFactory;
    protected $fillable = [
        'prefix',
        'plate', 
        'model', 
        'brand',
        'chassis',
        'type',
        'capacity',
        'year',
        'features'
    ];

    protected $casts = [
        'features' => 'array'
    ];

    public function trips(): HasMany {
        return $this->hasMany(Trip::class);
    }
}