<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimberCuttingPermitApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return [
//            "name"=> $this->name,
//            "address"=> $this->address,
//            "contact_number"=> $this->contact_number,
//            "timber_seller_checked_value"=> $this->timber_seller_checked_value,
//            "non_commercial_use_checked_value"=> $this->non_commercial_use_checked_value,
//            "gn_division"=> $this->gnDivision,
//            "deed_detail"=> $this->deedDetail,
//            "ownership_of_land_checked_value"=> $this->ownership_of_land_checked_value,
//            "land_detail"=>$this->landDetail,
//            "boundaries"=> $this->boundaries,
//            "tree_count"=> $this->treeCount,
//            "tree_detail"=> $this->treeDetail,
//            "reason_to_cut_trees"=> $this->reason_to_cut_trees,
//            "cutted_other_tree_count"=> $this->cutted_other_tree_count,
//            "planted_tree_count"=> $this->planted_tree_count,
//            "road_to_land"=> $this->road_to_land,
//
//        ];
        return [
            "id"=>$this['id'],
            "name"=> $this->name,
            "address"=> $this->address,
            "contact_number"=> $this->contact_number,
            "timber_seller_checked_value"=> $this->timber_seller_checked_value,
            "non_commercial_use_checked_value"=> $this->non_commercial_use_checked_value,
            "gn_division"=> $this->gn_division,
            "deed_detail"=> $this->deed_detail,
            "status"=>$this->status,
            "submission_timestamp"=>$this->submission_timestamp,
            "checked_date"=>$this->checked_date,
//            "checked_time"=>$this->checked_time,
            "ownership_of_land_checked_value"=> $this->ownership_of_land_checked_value,
            "land_detail"=>$this->land_detail,
            "boundary"=> $this->boundary,
            "tree_count"=> $this->tree_count,
            "tree_details"=> $this->tree_details,
            "tree_cutting_reasons"=> $this->tree_cutting_reasons,
            "trees_cut_before"=> $this->trees_cut_before,
            "planted_tree_count"=> $this->planted_tree_count,
            "road_to_land"=> $this->road_to_land,
            "comment"=>$this->comment,
            "updated_at"=>$this->updated_at
//            "reasons"=>

        ];
    }
}
