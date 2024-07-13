<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamurdhiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'income_certificate_id', 'subside_amount', 'is_subsidiaries_returned', 'recommendation', 'checked_date'
    ];

    public function incomeCertificate()
    {
        return $this->belongsTo(IncomeCertificate::class);
    }
}
