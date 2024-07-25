<?php

namespace App\DTO;

class IncomeCertificateDTO
{
    public string $name;
    public string $address;
    public string $nic;
    public string $contact_number;
    public array $gn_division;
    public string $purpose;
    public string $submitting_institute;
    public array $incomes;
    public string $total_annual_income;
    public ?string $income_tax_number;
    public ?string $is_samurdhi_beneficiary;
    public array $samurdhi_details;
    public string $checked_date;
    public ?string $checked_time;
    public ?string $comment;
    public string $status;
    public ?string $submission_timestamp;
    public ?string $application_code;

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
