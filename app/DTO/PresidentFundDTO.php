<?php
namespace App\DTO;

class PresidentFundDTO
{
    public string $name;
    public string $address;
    public string $nic;
    public string $contact_number;
    public array $gn_division;
    public string $status;
    public string $submission_timestamp;
    public ?string $comment;
    public string $application_code;
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
