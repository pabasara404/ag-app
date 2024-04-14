<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\DTO\TimberCuttingPermitApplicationDTO;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
       $data = [
            'id'=>1,
            'name'=>'fahgjfhg',
            'address'=>'fahgjfhg',
            'contact_number'=>'fahgjfhg',
            'timber_seller_checked_value'=>'fahgjfhg',
            'non_commercial_use_checked_value'=>'fahgjfhg',
            'grama_niladari_division'=>'fahgjfhg',
            'deed_details'=>'fahgjfhg',
            'ownership_of_land_checked_value'=>'fahgjfhg',
            'land_details'=>'fahgjfhg',
            'boundaries'=>'fahgjfhg',
            'tree_count'=>'fahgjfhg',
            'tree_details'=>'fahgjfhg',
            'tree_cutting_reasons'=>'fahgjfhg',
            'cutted_other_tree_count'=>'fahgjfhg',
            'planted_tree_count'=>'fahgjfhg',
            'road_to_land'=>'fahgjfhg',
            'guna'=>'fahgjfhg',
       ];

       $dto = new TimberCuttingPermitApplicationDTO($data);
       dd($dto->id);
    }
}
