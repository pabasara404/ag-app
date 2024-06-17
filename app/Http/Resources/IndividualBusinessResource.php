<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndividualBusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "business_name"=>$this->business_name,
            "nature"=>$this->nature,
            "principal_place"=>$this->principal_place,
            "initial_capital"=>$this->initial_capital,
            "start_date"=>$this->start_date,
            "is_other_business_value"=>$this->is_other_business_value,
            "is_director"=>$this->is_director,
            "other_business_name"=>$this->other_business_name,
            "government_officer_checked_value"=>$this->government_officer_checked_value,
            "contact_number"=>$this->contact_number,
            "ownership_of_land_checked_value"=>$this->ownership_of_land_checked_value,
            "checked_date"=>$this->checked_date,
            "checked_time"=>$this->checked_time,
            "addresses"=>$this->addresses,
            "owner_detail"=>$this->owner_detail,
            "other_businesses"=>$this->other_businesses,
            "director_details"=>$this->director_details
        ];
    }
}
