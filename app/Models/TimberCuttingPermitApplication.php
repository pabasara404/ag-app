<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TimberCuttingPermitApplication extends Model
{
    use HasFactory;

    protected $fillable=[
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
        'tree_detail_id'
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
//    public function tree_count(){
//        return $this->belongsTo(TreeCount::class);
//    }
    public function citizen(){
        return $this->belongsTo(Citizen::class);
    }
    public function tree_cutting_reasons(): BelongsToMany
    {
        return $this->belongsToMany(TreeCuttingReason::class,'permit_application_cutting_reason','permit_application_id','cutting_reason_id');
    }

    public function transitionTo($newStatus)
    {
        $allowedTransitions = [
            'Submitted' => ['Under Review'],
            'Under Review' => ['Pending', 'Escalated'],
            'Pending' => ['Under Review'],
            'Escalated' => ['Rejected', 'Approved'],
            'Approved' => ['Awaiting Payment'],
            'Awaiting Payment' => ['Closed']
        ];

        if (in_array($newStatus, $allowedTransitions[$this->status])) {
            $this->status = $newStatus;
            $this->save();
            return true;
        }

        return false;
    }
}
