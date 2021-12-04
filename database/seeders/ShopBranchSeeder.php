<?php

namespace Database\Seeders;

use App\Models\ShopBranch;
use Illuminate\Database\Seeder;

class ShopBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShopBranch::insert([
                [
                    'name' => 'Հյուսիսային պողոտա',
                    'address' => 'Երևան, Հյուսիսային պողոտա 5',
                    'phone_numbers' => json_encode([["phone" => "(+374) 11-511166"], ["phone" => "(+374) 91-511166"]]),
                    'working_days' => json_encode([
                        "1" => "10:15-22:00",
                        "2" => "10:15-22:00",
                        "3" => "10:15-22:00",
                        "4" => "10:15-22:00",
                        "5" => "10:15-22:00",
                        "6" => "10:15-22:00",
                        "7" => "10:15-22:00"
                    ]),
                    'shop_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Ռիո Մոլ',
                    'address' => 'Երևան, Փափազյան 8',
                    'phone_numbers' => json_encode([["phone" => "(+374) 11-511166"], ["phone" => "(+374) 91-511166"]]),
                    'working_days' => json_encode([
                        "1" => "10:15-22:00",
                        "2" => "10:15-22:00",
                        "3" => "10:15-22:00",
                        "4" => "10:15-22:00",
                        "5" => "10:15-22:00",
                        "6" => "10:15-22:00",
                        "7" => "10:15-22:00"
                    ]),
                    'shop_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
