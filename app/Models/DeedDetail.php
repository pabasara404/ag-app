<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeedDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_deed_number',
        'land_deed_date',
    ];
    public function timberCuttingPermitApplication()
    {
        return $this->hasOne(TimberCuttingPermitApplication::class);    }
}
