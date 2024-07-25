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
            'name' => $this->name,
            'address' => $this->address,
            'nic' => $this->nic,
            'contact_number' => $this->contact_number,
            'business_name' => $this->business_name,
            'issued_date' => $this->issued_date,
            'expire_date' => $this->expire_date,
            'gn_division' => $this->gnDivision ? $this->gnDivision->toArray() : null,
            'status' => $this->status,
            'submission_timestamp' => $this->submission_timestamp,
            'comment' => $this->comment,
            'application_code' => $this->application_code,
        ];
    }
}
