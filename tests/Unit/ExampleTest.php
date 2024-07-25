<?php

namespace Tests\Unit;

use App\Actions\TimberCuttingPermitApplicationAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    use RefreshDatabase, WithFaker;

    public function test_store_method_creates_a_new_citizen()
    {
        // Create a user to associate with the citizen
        $user = User::factory()->create();

        // Mock request data
        $data = [
            'name' => $this->faker->name,
            'nic' => $this->faker->unique()->numerify('#########V'),
            'address' => $this->faker->address,
            'contact_number' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date(),
            'gn_division_id' => 1, // Assuming this exists in your GN divisions table
            'user_id' => $user->id,
        ];

        // Make a POST request to the store method
        $response = $this->postJson('/citizens', $data);

        // Assert that the response status is 204 (no content)
        $response->assertStatus(204);

        // Assert that the citizen was created in the database
        $this->assertDatabaseHas('citizens', [
            'name' => $data['name'],
            'nic' => $data['nic'],
            'address' => $data['address'],
            'contact_number' => $data['contact_number'],
            'date_of_birth' => $data['date_of_birth'],
            'gn_division_id' => $data['gn_division_id'],
            'user_id' => $data['user_id'],
        ]);
    }
}



