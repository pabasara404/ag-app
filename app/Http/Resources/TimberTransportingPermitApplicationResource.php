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
            "address_of_timber"=>$this->address_of_timber,
            "is_timber_bought_checked_value"=>$this->is_timber_bought_checked_value,
            "receipt_no"=>$this->receipt_no,
            "bought_date"=>$this->bought_date,
            "road_to_timber_location"=>$this->road_to_timber_location,
            "is_timber_private_land_checked_value"=>$this->is_timber_private_land_checked_value,
            "end_location"=>$this->end_location,
            "route"=>$this->route,
            "timber_transport_date"=>$this->timber_transport_date,
            "plate_number"=>$this->plate_number,
            "total_pieces"=>$this->total_pieces,
            "private_land"=>$this->private_land,
            "boundary"=>$this->boundary,
            "timber_details"=>$this->timber_details,
            "gn_division"=>$this->gn_division

        ];

}
}
