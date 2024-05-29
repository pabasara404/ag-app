<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Citizen;
use App\Models\GnOfficer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
//        User::factory(10)->create();
        $this->call(RoleSeeder::class);

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'admin@example.com',
             'password' => Hash::make('12345678'),
             'role_id' => '1',
         ]);

         User::factory()->create([
             'name' => 'Guest User',
             'email' => 'guest@example.com',
             'password' => Hash::make('12345678'),
             'role_id' => '3',
         ]);

         User::factory()->create([
             'name' => 'General User',
             'email' => 'general@example.com',
             'password' => Hash::make('12345678'),
             'role_id' => '2',
         ]);

//        GnOfficer::factory(10)->create();
//        Citizen::factory(10)->create();

//        $employeeSeeder->run();
        $this->call(GnDivisionSeeder::class);
        $this->call(TreeCuttingReasonSeeder::class);
    }
}
