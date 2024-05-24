<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GnDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'gn_code',
        'name',
        'mpa_code',
        'gn_officer_id',
    ];

    public function timberCuttingPermitApplication()
    {
        return $this->hasMany(TimberCuttingPermitApplication::class);
    }
    public function citizen()
    {
        return $this->hasMany(Citizen::class);
    }

    public function gnOfficer(){
        return $this->belongsTo(GnOfficer::class);
    }
}
