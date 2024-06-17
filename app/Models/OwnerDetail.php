<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'previous_name',
        'nationality',
        'nic',
        'residence'
    ];

    public function individual_business(){
        return $this->hasOne(IndividualBusiness::class);
    }
}
