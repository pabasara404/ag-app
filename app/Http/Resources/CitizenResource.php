<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenResource extends JsonResource
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
            "nic"=>$this->nic,
            "address"=>$this->address,
            "contact_number"=>$this->contact_number,
            "date_of_birth"=>$this->date_of_birth,
            "gn_division"=>$this->gn_division,
            "user"=>$this->user,
        ];
    }
}
