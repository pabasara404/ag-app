<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_no',
        'business_name',
        'individual_business_id',
        'partner_id'
    ];

    public function individual_business(){
        $this->belongsTo(IndividualBusiness::class);
    }

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
