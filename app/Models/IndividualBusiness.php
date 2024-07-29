<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'nature',
        'principal_place',
        'initial_capital',
        'start_date',
        'is_other_business_value',
        'is_director',
        'other_business_name',
        'government_officer_checked_value',
        'contact_number',
        'ownership_of_land_checked_value',
        'checked_date',
        'status',
        'submission_timestamp',
        'application_code',
        'owner_detail_id',
        'citizen_id',
        'gn_division_id',
    ];

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function owner_detail(){
        return $this->belongsTo(OwnerDetail::class);
    }

    public function other_businesses(){
        return $this->hasMany(OtherBusiness::class);
    }

    public function director_details(){
        return $this->hasMany(DirectorDetail::class);
    }

    public function gn_division()
    {
        return $this->belongsTo(GnDivision::class);
    }


    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/IBR/{$newCode}";
    }
}
