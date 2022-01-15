<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['title', 'image', 'parent_id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            foreach ($model->childs as $child) {
                $child->parent_id = 0;
                $child->save();
            }
            $model->products()->detach();
        });
    }

    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }
    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'category_product')->withPivot('category_id');
    }

    public function children()
    {
        return $this->childs()->with('children');
    }
}
