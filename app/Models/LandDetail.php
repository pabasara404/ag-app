<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'land_name',
        'land_size',
        'plan_number',
        'plan_date',
        'plan_plot_number',
    ];
    public function timberCuttingPermitApplication()
    {
        return $this->hasOne(TimberCuttingPermitApplication::class);
    }
}
