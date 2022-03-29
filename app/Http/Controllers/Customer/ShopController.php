<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\User\ShopResource;
use App\Models\Shop;
use App\Models\ShopBranch;
use Illuminate\Http\Request;

class ShopController extends Controller
{


    /**
     * Display a listing of the shop.
     *
     * @return ShopResource
     */
    public function topShops()
    {
        $shops = Shop::withTrashed()->with('branches')->take(6);
        return response()->json([
            'data' => ShopResource::collection($shops->get()),
        ], 200);
    }

    /**
     * Display a listing of the shop.
     *
     * @return ShopResource
     */
    public function index(Request $request)
    {
        $shops = Shop::withTrashed()->with('branches');
        $page = $request->input('page') ? : 1;
        $take = $request->input('count') ? : 6;
        $count = $shops->count();

        if ($search = $request->input('search')) {
            $shops = $shops->where('name', 'like', "%{$search}%");;
        }

        if ($request->input('sort')) {
            $sort = explode(".", $request->input('sort'));
            $shops = $shops->orderBy($sort[0], $sort[1]);
        } else {
            $shops = $shops->orderBy('id', 'DESC');
        }

        if ($page) {
            $skip = $take * ($page - 1);
            $shops = $shops->take($take)->skip($skip);
        } else {
            $shops = $shops->take($take)->skip(0);
        }

        return response()->json([
            'data' => ShopResource::collection($shops->get()),
            'pagination'=>[
                'count_pages' => ceil($count / $take),
                'count' => $count
            ]
        ], 200);
    }


    /**
     * Display the specified resource.
     * @param $id
     * @return ShopResource
     */
    public function show($id)
    {
        $shop = Shop::withTrashed()->findOrFail($id);
        $shop->load('branches');

        return new ShopResource($shop);
    }




}
