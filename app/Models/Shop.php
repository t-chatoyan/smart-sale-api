<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Shop extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
    ];

    public function branches()
    {
        return $this->hasMany(ShopBranch::class);
    }

    public function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')->width(450)->format('webp');

        $this->addMediaConversion('small')->width(350)->format('webp');
    }

}
