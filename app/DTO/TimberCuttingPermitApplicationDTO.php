<?php

namespace App\DTO;

use App\Models\GnDivision;

class TimberCuttingPermitApplicationDTO
{
    public int | null $id;
    public string $name;
    public string $address;
    public string $contact_number;
    public string $timber_seller_checked_value;
    public string $non_commercial_use_checked_value;
    public array $gn_division;
    public array $deed_details;
    public string $ownership_of_land_checked_value;
    public string $status;
    public array $land_detail;
    public array $boundary;
    public string $tree_count;
    public array $tree_details;
    public array $tree_cutting_reasons;
    public string $trees_cut_before;
    public string $planted_tree_count;
    public string $road_to_land;
    public ?string $submission_timestamp;
    public ?string $checked_date;
    public ?string $checked_time;
    public ?string $comment;


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
