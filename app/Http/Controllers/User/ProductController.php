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

        $products = Product::withTrashed()->with('categories')->whereHas('shop', function($q){
                $q->where('owner_id', auth()->id());
        });

        if ($request->input('sort')) {
            $sort = explode(".", $request->input('sort'));
            $products = $products->orderBy($sort[0], $sort[1]);
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

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
        $product = Product::with('categories', 'shop')->where('id', $id)->where('owner_id', auth()->id())->first();

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  int  $id
     * @return ProductResource
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        dd($data);
        $data['owner_id'] = auth()->id();
        $product = Product::findOrFail($id);

        if ($request->hasFile('photos')) {
            $product->addMultipleMediaFromRequest(['photos'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('product_photos', 'public');
            });
        }

        $product->categories()->sync($request->get('categories'));
        $product->update($data);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => 'Product updated successfully!'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::withTrashed()->findOrFail($id);

        $deleteType = null;

        if(!$product->trashed()){
            $product->delete();
            $deleteType = 'delete';
        }
        else {
            $deleteType = 'forceDelete';
            $product->forceDelete();
        }

        return response()->json([
            'status' => true,
            'deleteType' => $deleteType,
            'message' => 'Product has been deleted successfully!'
        ], 200);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {

        $product = Product::withTrashed()->findOrFail($id);

        $product->restore();

        return response()->json([
            'status'   => true,
            'data' => new ProductResource($product),
            'message'  => 'Product has been restored successfully!'
        ], 200);
    }
}
