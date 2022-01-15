<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::insert([
                [
                    'name' => 'Sali shoes',
                    'description' => '<p>SALI կոշիկի խանութ-սրահներն</p>',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'name',
                    'description' => '<p>name name name name name name</p>',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'name',
                    'description' => '<p>name name name name name name</p>',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
