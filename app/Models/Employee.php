<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nic',
        'address',
        'contact_number',
        'date_of_birth',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
