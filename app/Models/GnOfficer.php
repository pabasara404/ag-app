<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GnOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function gn_divisions(){
        return $this->hasMany(GnDivision::class);
    }
}
