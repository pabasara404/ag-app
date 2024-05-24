<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nic',
        'address',
        'contact_number',
        'date_of_birth',
        'gn_division_id',
        'user_id',
    ];

    public function licenses(){
        $this->hasMany(License::class);
    }
    public function timberCuttingPermitApplication(){
        $this->hasMany(TimberCuttingPermitApplication::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gn_division(){
        return $this->belongsTo(GnDivision::class);
    }
}
