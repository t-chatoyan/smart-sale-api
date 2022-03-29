<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProductResource;
use App\Models\Product;
use App\Models\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Support\MediaLibraryPro;

class ProductController extends Controller
{


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function topProduct()
    {
        $products = Product::withTrashed()->take(6);
        return response()->json([
            'data' => ProductResource::collection($products->get()),
        ], 200);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::with('categories');

        if ($search = $request->input('search')) {
            $products = $products->where('name', 'like', "%{$search}%");;
        }

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
     * Display the specified resource.
     *
     * @param $id
     * @return ProductResource
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return new ProductResource($product->load('categories', 'shop'));
    }

    public function test(Request $request)
    {
        $test = Test::create($request->all());
        return response()->json([
            'data' => $test
        ], 200);
    }

    public function shoTest()
    {
        $tests = Test::orderBy('id', 'DESC')->get();

        return response()->json([
            'data' => $tests,
            'count' =>  $tests->count()
        ], 200);
    }
}
