<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnimalTransportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_code',
        'name',
        'address',
        'contact_number',
        'reason_to_transport',
        'start_point',
        'destination',
        'cost_per_animal',
        'issued_date',
        'expire_date',
        'checked_date',
        'status',
        'submission_timestamp',
//        'checked_time',
        'comment',
    ];

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/ATP/{$newCode}";
    }
}
