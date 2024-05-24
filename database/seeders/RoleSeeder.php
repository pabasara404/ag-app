<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::$roleTypes;
        $roles = collect($roles)->map(function ($role, $id) {
            return [
                'role_type' => $id,
            ];
        });
        DB::table('roles')->insert($roles->toArray());
    }
}
