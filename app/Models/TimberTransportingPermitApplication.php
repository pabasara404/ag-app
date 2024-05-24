<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimberTransportingPermitApplication extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'address',
        'contact_number',
        'address_of_timber',
        'is_timber_bought_checked_value',
        'receipt_no',
        'bought_date',
        'road_to_timber_location',
        'is_timber_private_land_checked_value',
        'end_location',
        'route',
        'timber_transport_date',
        'plate_number',
        'total_pieces',
        'private_land_detail_id',
        'private_land_details',
        'timber_detail_id'
    ];

    public function timber_details(){
        return $this->hasMany(TimberDetail::class);
    }

    public function boundary(){
        return $this->belongsTo(Boundaries::class);
    }

    public function private_land_detail(){
        return $this->belongsTo(PrivateLandDetail::class);
    }
}
