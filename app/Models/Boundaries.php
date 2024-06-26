<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boundaries extends Model
{
    use HasFactory;

    protected $fillable =[
        "north",
        "south",
        "east",
        "west"
    ];

    public function timberCuttingPermitApplication()
    {
        return $this->hasOne(TimberCuttingPermitApplication::class);
    }
}
