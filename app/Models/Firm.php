<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'nature',
        'principal_place',
        'initial_capital',
        'start_date',
        'checked_date',
        'comment',
        'is_other_business_value',
        'is_other_occupation_value',
        'ownership_of_land_checked_value',
        'status',
        'submission_timestamp',
        'application_code',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public static function generateApplicationCode()
{
    $lastBusiness = self::orderBy('id', 'desc')->first();
    $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
    $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
    return "WP/KTN/FR/{$newCode}";
}
}
