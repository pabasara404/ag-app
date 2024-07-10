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
//        'checked_time',
        'owner_detail_id',
        'citizen_id'
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
}
