<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TreeCuttingReason extends Model
{
    use HasFactory;

    public function timberCuttingPermitApplications(): BelongsToMany
    {
        return $this->belongsToMany(TimberCuttingPermitApplication::class,'permit_application_cutting_reason','cutting_reason_id','permit_application_id');
    }
}
