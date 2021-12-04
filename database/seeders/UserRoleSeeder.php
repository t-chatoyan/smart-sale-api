<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::insert([
                [
                    'name' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
