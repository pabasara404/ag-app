<?php

namespace App\Http\Resources;

use App\Models\OtherPartneredBusiness;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'previous_name' => $this->previous_name,
            'government_officer_checked_value' => $this->government_officer_checked_value,
            'nationality' => $this->nationality,
            'nic' => $this->nic,
            'contact_number' => $this->contact_number,
            'residence' => $this->residence,
            'is_other_occupation_value' => $this->is_other_occupation_value,
            'occupation' => $this->occupation,
            'is_other_business_value' => $this->is_other_business_value,
            'is_director' => $this->is_director,
            'ownership_of_land_checked_value' => $this->ownership_of_land_checked_value,
            'other_partnered_businesses' => OtherPartneredBusinessResource::collection($this->otherBusinesses),
            'director_details' => DirectorDetailResource::collection($this->directorDetails),
        ];
    }
}
