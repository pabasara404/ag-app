<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_no',
        'business_name',
    ];

    public function individual_business(){
        return $this->belongsTo(IndividualBusiness::class);
    }
}
