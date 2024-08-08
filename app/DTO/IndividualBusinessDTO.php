<?php

namespace App\DTO;

class IndividualBusinessDTO
{

    public string $business_name;
    public string $nature;
    public string $principal_place;
    public string $initial_capital;
    public string $start_date;
    public string $is_other_business_value;
    public string $is_director;
    public string $other_business_name;
    public string $government_officer_checked_value;
    public string $contact_number;
    public string $ownership_of_land_checked_value;
    public string $checked_date;
//    public ?string $checked_time;
    public array $addresses;
    public array $owner_detail;
    public array $other_businesses;
    public array $director_details;
    public ?string $submission_timestamp;
    public ?string $checked_time;
    public ?string $comment;
    public string $status;
    public ?string $application_code;
    public array $gn_division;
    public array $user;

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
