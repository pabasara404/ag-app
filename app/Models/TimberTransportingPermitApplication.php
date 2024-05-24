<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimberTransportingPermitApplication extends Model
{
    use HasFactory;

    protected $table = 'timber_transporting_applications';

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
        'private_land_id',
        'gn_division_id',
        'timber_detail_id'
    ];

    public function gn_division(){
        return $this->belongsTo(GnDivision::class);
    }

    public function timber_details(){
        return $this->hasMany(TimberDetail::class);
    }

    public function boundary(){
        return $this->belongsTo(Boundaries::class);
    }

    public function private_land(){
        return $this->belongsTo(PrivateLandDetail::class);
    }
}
