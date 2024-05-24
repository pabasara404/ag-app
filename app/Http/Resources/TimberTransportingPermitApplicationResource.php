<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimberTransportingPermitApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=>$this->name,
            "address"=>$this->address,
            "contact_number"=>$this->contact_number,
            "timber_seller_checked_value"=>$this->timber_seller_checked_value,
            "non_commercial_use_checked_value"=>$this->non_commercial_use_checked_value,
            "ownership_of_land_checked_value"=>$this->ownership_of_land_checked_value,
            "trees_cut_before"=>$this->trees_cut_before,
            "planted_tree_count"=>$this->planted_tree_count,
            "road_to_land"=>$this->road_to_land,
            "reasons"=>$this->reasons,
            "gn_division_id"=>$this->gn_division_id,
            "deed_detail_id"=>$this->deed_detail_id,
            "land_detail_id"=>$this->land_detail_id,
            "boundary_id"=>$this->boundary_id,
            "tree_count_id"=>$this->tree_count_id,
            "citizen_id"=>$this->citizen_id,
            "tree_detail_id"=>$this->tree_detail_id
        ];

}
}
