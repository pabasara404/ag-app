<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherPartneredBusinessResource extends JsonResource
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
            'registration_no' => $this->registration_no,
            'business_name' => $this->business_name,
            'registered_date' => $this->registered_date,
            'nature' => $this->nature,
        ];
    }
}
