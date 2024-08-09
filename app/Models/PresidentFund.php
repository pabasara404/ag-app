<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresidentFund extends Model
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
        'file_paths',
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
