<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_numbers',
        'working_days',
        'shop_id'
    ];


    const IMAGE_SETTINGS = [
        'images' => [
            'sizes' => [
                'full' => 184,
                'medium' => 64,
                'small' => 32,
            ],
            'path' => 'app/public/shop/images/',
            'read_path' => 'storage/shop/images/',
        ]
    ];

}
