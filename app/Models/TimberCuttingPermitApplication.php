<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TimberCuttingPermitApplication extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'name',
        'address',
        'contact_number',
        'timber_seller_checked_value',
        'non_commercial_use_checked_value',
        'ownership_of_land_checked_value',
        'trees_cut_before',
        'planted_tree_count',
        'road_to_land',
        'reasons',
        'status',
        'submission_timestamp',
        'checked_date',
        'checked_time',
        'gn_division_id',
        'deed_detail_id',
        'land_detail_id',
        'boundary_id',
        'tree_count',
        'citizen_id',
        'tree_detail_id',
        'comment',
        'application_code',
        'user_id'
    ];

    protected $casts = [
        'reasons' => 'array'
    ];

    public function gn_division(){
        return $this->belongsTo(GnDivision::class);
    }
    public function tree_details(){
        return $this->hasMany(TreeDetail::class);
    }
    public function deed_detail(){
        return $this->belongsTo(DeedDetail::class);
    }
    public function land_detail(){
        return $this->belongsTo(LandDetail::class);
    }
    public function boundary(){
        return $this->belongsTo(Boundaries::class);
    }
    public function tree_cutting_reasons(): BelongsToMany
    {
        return $this->belongsToMany(TreeCuttingReason::class,'permit_application_cutting_reason','permit_application_id','cutting_reason_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateApplicationCode()
    {
        $lastBusiness = self::orderBy('id', 'desc')->first();
        $lastCode = $lastBusiness ? (int)substr($lastBusiness->application_code, -6) : 0;
        $newCode = str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        return "WP/KTN/TCP/{$newCode}";
    }
}
