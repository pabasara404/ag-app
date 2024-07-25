<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuation extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_code',
        'name',
        'address',
        'valuation_amount',
        'reason',
        'land_deed_number',
        'to_north',
        'to_south',
        'to_east',
        'to_west',
        'size',
        'length',
        'width',
        'notary_officer_name',
        'plan_number',
        'plan_date',
        'land_name',
        'gn_division_id',
        'status',
        'submission_timestamp',
        'checked_date',
        'comment',
    ];

    public function gn_division()
    {
        return $this->belongsTo(GnDivision::class);
    }

    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/VC/{$newCode}";
    }
}
