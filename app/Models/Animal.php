<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_no',
        'identification_no',
        'species',
        'breed',
        'age',
        'ex',
        'color',
        'specific_marks',
        'health_certificate_no',
        'vehicle_registration_no',
        'animal_transportation_id',
    ];

    public function animalTransportation(): BelongsTo
    {
        return $this->belongsTo(AnimalTransportation::class);
    }
}
