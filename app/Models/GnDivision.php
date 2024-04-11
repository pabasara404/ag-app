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
        'grama_officer_id',
    ];

    public function timberCuttingPermitApplication()
    {
        return $this->hasOne(TimberCuttingPermitApplication::class);    }
}
