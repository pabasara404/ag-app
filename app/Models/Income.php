<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'income_certificate_id', 'source_of_income', 'registration_no', 'name', 'size', 'monthly_income', 'annual_income'
    ];

    public function incomeCertificate()
    {
        return $this->belongsTo(IncomeCertificate::class);
    }
}
