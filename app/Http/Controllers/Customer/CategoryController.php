<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $categories = Category::where('parent_id', null)->with('children')->get();

        return CategoryResource::collection($categories);
    }

    /**
     * @param $id
     * @return CategoryResource
     */
    public function show($id)
    {
        $category = Category::find($id);

        return new CategoryResource($category->load('children'));
    }
}
