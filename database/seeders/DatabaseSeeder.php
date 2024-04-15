<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\GnOfficer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(EmployeeSeeder $employeeSeeder)
    {
//         \App\Models\User::factory(10)->create();

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'admin@example.com',
             'password' => Hash::make('12345678'),
         ]);

        GnOfficer::factory(10)->create();

        $employeeSeeder->run();
        $this->call(RoleSeeder::class);
        $this->call(GnDivisionSeeder::class);
        $this->call(TreeCuttingReasonSeeder::class);
    }
}
