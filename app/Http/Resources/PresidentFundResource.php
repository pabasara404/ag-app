<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresidentFundResource extends JsonResource
{
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'address' => $this->address,
        'nic' => $this->nic,
        'contact_number' => $this->contact_number,
        "gn_division"=> $this->gn_division,
        'status' => $this->status,
        'submission_timestamp' => $this->submission_timestamp,
        'comment' => $this->comment,
        'application_code' => $this->application_code,
        'updated_at' => $this->updated_at,
        "user"=>$this->user,
        ];
    }
}
