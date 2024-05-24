<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimberDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'timber_type',
        'length',
        'width',
        'piece_count'
    ];

    public function timberTransportingPermitApplication()
    {
        return $this->hasOne(TimberTransportingPermitApplication::class);
    }
}
