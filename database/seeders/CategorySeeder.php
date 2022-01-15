<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'title' => 'Կանացի Հագուստ',
            ],
            [
                'title' => 'Մանկական Հագուստ',
            ],
            [
                'title' => 'Տղամարդու Հագուստ',
            ],
            [
                'title' => 'Աքսեսուարներ',
            ],
        ]);
        Category::insert([
            //Կանացի Հագուստ
            [
                'parent_id' => 1,
                'title' => 'Սպորտային հագուստ',
            ],
            [
                'parent_id' => 1,
                'title' => 'Հագուստ',
            ],
            [
                'parent_id' => 1,
                'title' => 'Բաճկոններ և վերարկուներ',
            ],
            //Մանկական Հագուստ
            [
                'parent_id' => 2,
                'title' => 'Սպորտային հագուստ',
            ],
            [
                'parent_id' => 2,
                'title' => 'Հագուստ',
            ],
            [
                'parent_id' => 2,
                'title' => 'Բաճկոններ և վերարկուներ',
            ],
            //Տղամարդու Հագուստ
            [
                'parent_id' => 3,
                'title' => 'Սպորտային հագուստ',
            ],
            [
                'parent_id' => 3,
                'title' => 'Հագուստ',
            ],
            [
                'parent_id' => 3,
                'title' => 'Բաճկոններ և վերարկուներ',
            ],
            //Աքսեսուարներ
            [
                'parent_id' => 4,
                'title' => 'Զարդեր',
            ],
            [
                'parent_id' => 4,
                'title' => 'Ակնոցներ և շրջանակներ',
            ],
            [
                'parent_id' => 4,
                'title' => 'Ձեռքի ժամացույցներ',
            ],
            [
                'parent_id' => 4,
                'title' => 'Գոտիներ',
            ],
            [
                'parent_id' => 4,
                'title' => 'Հովանոցներ',
            ],
            [
                'parent_id' => 4,
                'title' => 'Պայուսակներ և դրամապանակներ',
            ]
        ]);
    }
}
