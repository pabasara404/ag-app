<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'nic', 'contact_number', 'gn_division_id',
        'purpose', 'submitting_institute', 'total_annual_income',
        'income_tax_number', 'is_samurdhi_beneficiary', 'checked_date',
        'status', 'submission_timestamp', 'checked_time', 'comment', 'application_code'
    ];

    public function gn_division()
    {
        return $this->belongsTo(GnDivision::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function samurdhi_details()
    {
        return $this->hasOne(SamurdhiDetail::class);
    }

    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/IC/{$newCode}";
    }
}
