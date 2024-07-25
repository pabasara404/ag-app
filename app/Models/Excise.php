<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'nic',
        'contact_number',
        'business_name',
        'issued_date',
        'expire_date',
        'gn_division_id',
        'status',
        'submission_timestamp',
        'comment',
        'application_code'
    ];

    public function gn_division()
    {
        return $this->belongsTo(GNDivision::class);
    }

    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/EL/{$newCode}";
    }
}
