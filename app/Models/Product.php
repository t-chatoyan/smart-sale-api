<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
       'name',
       'code',
       '1c_id',
       'description',
       'short_description',
       'price',
       'old_price',
       'discount',
       'in_stock',
       'shop_id',
       'owner_id',
       'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    protected $appends = ['photos'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_product')->withPivot('product_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User','owner_id','id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop','shop_id','id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')->width(450)->format('webp');

        $this->addMediaConversion('small')->width(350)->format('webp');
    }
}
