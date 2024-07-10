<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'full_name',
        'previous_name',
        'government_officer_checked_value',
        'nationality',
        'nic',
        'contact_number',
        'residence',
        'is_other_occupation_value',
        'occupation',
        'is_other_business_value',
        'is_director'
    ];

    public function firm(){
        return $this->belongsTo(Firm::class);
    }

    public function other_partnered_businesses(){
        return $this->hasMany(OtherPartneredBusiness::class);
    }

    public function director_details(){
        return $this->hasMany(DirectorDetail::class);
    }
}
