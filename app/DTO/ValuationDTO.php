<?php

namespace App\DTO;

class ValuationDTO
{
    public string $name;
    public string $address;
    public string $valuation_amount;
    public string $reason;
    public string $land_deed_number;
    public string $to_north;
    public string $to_south;
    public string $to_east;
    public string $to_west;
    public string $size;
    public string $length;
    public string $width;
    public string $notary_officer_name;
    public string $plan_number;
    public string $plan_date;
    public string $land_name;
    public array $gn_division;
    public string $checked_date;
    public ?string $comment;
    public string $status;
    public ?string $submission_timestamp;
    public ?string $application_code;
    public array $user;


    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        if (empty($this->submission_timestamp)) {
            $this->submission_timestamp = now()->toDateTimeString();
        }
    }
}
