<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_no',
        'type',
        'height',
        'girth',
        'reproducibility',
        'age',
        'timber_cutting_permit_application_id'
    ];

    public function timberCuttingPermitApplication()
    {
        return $this->belongsTo(TimberCuttingPermitApplication::class);
    }
}
