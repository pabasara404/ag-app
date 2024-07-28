<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahapola extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'nic',
        'contact_number',
        'gn_division_id',
        'status',
        'submission_timestamp',
        'comment',
        'application_code'
    ];

    public function gn_division()
    {
        return $this->belongsTo(GNDivision::class);
    }
}
