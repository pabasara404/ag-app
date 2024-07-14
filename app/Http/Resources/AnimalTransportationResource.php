<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalTransportationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "application_code" => $this->application_code,
            "name" => $this->name,
            "address" => $this->address,
            "contact_number" => $this->contact_number,
            "reason_to_transport" => $this->reason_to_transport,
            "start_point" => $this->start_point,
            "destination" => $this->destination,
            "cost_per_animal" => $this->cost_per_animal,
            "issued_date" => $this->issued_date,
            "expire_date" => $this->expire_date,
            "checked_date" => $this->checked_date,
            "status" => $this->status,
            "submission_timestamp" => $this->submission_timestamp,
//            "checked_time" => $this->checked_time,
            "comment" => $this->comment,
            "animals" => $this->animals,
            'updated_at' => $this->updated_at,
        ];
    }
}
