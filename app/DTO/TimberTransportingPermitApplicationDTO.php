<?php

namespace App\DTO;

use App\Models\GnDivision;

class TimberTransportingPermitApplicationDTO
{
    public int | null $id;
    public string $name;
    public string $address;
    public string $contact_number;
    public string $timber_seller_checked_value;
    public string $non_commercial_use_checked_value;
    public array $grama_niladari_division;
    public array $deed_details;
    public string $ownership_of_land_checked_value;
    public array $private_lands;
    public array $boundaries;
    public array $tree_count;
    public array $timber_details;
    public array $tree_cutting_reasons;
    public string $cutted_other_tree_count;
    public string $planted_tree_count;
    public string $road_to_land;
    public ?string $checked_date;
    public ?string $submission_timestamp;
    public ?string $comment;
    public string $status;
    public ?string $application_code;
    public array $gn_division;

    public function __construct(array $data)
    {
        collect($data)->each(function ($value, $key) {
            if ($key === 'id' && empty($value)) {
                $this->id = null;
            } elseif ($key === 'submission_timestamp' && empty($value)) {
                $this->submission_timestamp = now()->toDateTimeString();
            } else {
                $this->{$key} = $value;
            }
        });

        return $this;
    }

}
