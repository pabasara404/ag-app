<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'payment_type',
        'application_code',
        'amount',
        'receipt_no',
        'paid_date',
        'contact_number',
        'nic',
        'file_path',
        'application_id',
        'application_table'
    ];

    // Cast the paid_date to a date instance
    protected $casts = [
        'paid_date' => 'date',
    ];

    /**
     * Get the application related to this payment.
     */
    public function application()
    {
        return $this->morphTo(null, 'application_table', 'application_id');
    }
}
