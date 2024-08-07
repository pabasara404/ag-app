<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'individual_business_id',
        'firm_id'
    ];

    public function individual_business(){
        return $this->belongsTo(IndividualBusiness::class);
    }

    public function firm(){
        return $this->belongsTo(Firm::class);
    }
}
