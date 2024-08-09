<?php

namespace App\DTO;

class AnimalTransportationDTO
{

    public ?string $application_code;
    public string $name;
    public string $address;
    public string $contact_number;
    public string $reason_to_transport;
    public string $start_point;
    public string $destination;
    public string $cost_per_animal;
    public ?string $issued_date;
    public ?string $expire_date;
    public ?string $checked_date;
    public string $status;
    public ?string $submission_timestamp;
    public ?string $comment;
    public array $animals;
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
