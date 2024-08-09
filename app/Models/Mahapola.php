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
        'application_code',
        'file_detail_ids',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gn_division()
    {
        return $this->belongsTo(GNDivision::class);
    }
}
