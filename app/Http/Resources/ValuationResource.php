<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValuationResource extends JsonResource
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
            'application_code' => $this->application_code,
            'name' => $this->name,
            'address' => $this->address,
            'valuation_amount' => $this->valuation_amount,
            'reason' => $this->reason,
            'land_deed_number' => $this->land_deed_number,
            'to_north' => $this->to_north,
            'to_south' => $this->to_south,
            'to_east' => $this->to_east,
            'to_west' => $this->to_west,
            'size' => $this->size,
            'length' => $this->length,
            'width' => $this->width,
            'notary_officer_name' => $this->notary_officer_name,
            'plan_number' => $this->plan_number,
            'plan_date' => $this->plan_date,
            'land_name' => $this->land_name,
            "gn_division"=> $this->gn_division,
            'status' => $this->status,
            'submission_timestamp' => $this->submission_timestamp,
            'checked_date' => $this->checked_date,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
