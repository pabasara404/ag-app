<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPartneredBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'registration_no',
        'business_name',
        'registered_date',
        'nature'
    ];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
