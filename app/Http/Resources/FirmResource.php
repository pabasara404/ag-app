<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FirmResource extends JsonResource
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
            'business_name' => $this->business_name,
            'nature' => $this->nature,
            'principal_place' => $this->principal_place,
            'initial_capital' => $this->initial_capital,
            'start_date' => $this->start_date,
            'checked_date' => $this->checked_date,
            'comment' => $this->comment,
            'is_other_business_value' => $this->is_other_business_value,
            'is_other_occupation_value' => $this->is_other_occupation_value,
            'ownership_of_land_checked_value' => $this->ownership_of_land_checked_value,
            'status' => $this->status,
            'addresses' => $this->addresses,
            'partners' => $this->partners,
            "updated_at"=>$this->updated_at,
            "submission_timestamp"=>$this->submission_timestamp,
            "application_code"=>$this->application_code
        ];
    }
}
