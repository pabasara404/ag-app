<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateLandDetail extends Model
{
    use HasFactory;

    protected $table = 'private_lands';

    protected $fillable = [
        'land_deed_number',
        'registration_date',
        'plan_plot_number',
        'registration_office',
        'plan_number',
        'land_name',
        'land_size'
    ];
    public function timberTransportingPermitApplication()
    {
        return $this->hasOne(TimberTransportingPermitApplication::class);
    }
}
