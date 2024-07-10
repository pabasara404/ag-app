<?php

namespace App\DTO;

class FirmDTO
{
    public ?int $id;
    public string $business_name;
    public string $nature;
    public string $principal_place;
    public string $initial_capital;
    public array $addresses;
    public string $start_date;
    public array $partner_details;
    public ?string $checked_date;
    public ?string $submission_timestamp;
    public ?string $comment;
    public ?string $status;
    public string $ownership_of_land_checked_value;
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
