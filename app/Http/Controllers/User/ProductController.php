<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProductRequest;
use App\Http\Resources\User\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('id', 'DESC');
        $page = $request->input('page') ? : 1;
        $take = $request->input('count') ? : 6;
        $count = $products->count();


        if ($page) {
            $skip = $take * ($page - 1);
            $products = $products->take($take)->skip($skip);
        } else {
            $products = $products->take($take)->skip(0);
        }

        return response()->json([
            'data' => ProductResource::collection($products->get()),
            'pagination'=>[
                'count_pages' => ceil($count / $take),
                'count' => $count
            ]
        ], 200);
    }

    /**
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['owner_id'] = auth()->id();

        $product = Product::create($data);
        $product->categories()->sync($request->get('categories'));

        if ($request->hasFile('photos')) {
            $product->addMultipleMediaFromRequest(['photos'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('product_photos', 'public');
            });
        }


        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return ProductResource
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->load('categories');

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response([
                "message" => "Shop deleted successfully!"
            ], 200);
        }
        return response([
            "message" => "Shop not found!"
        ], 400);
    }
}
