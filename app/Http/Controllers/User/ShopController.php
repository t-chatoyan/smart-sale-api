<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\User\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllShops(Request $request)
    {
        $shops = Shop::where('owner_id', auth()->id())->orderBy('id', 'DESC')->get();

        return ShopResource::collection($shops);
    }

    /**
     * Display a listing of the shop.
     *
     * @return ShopResource
     */
    public function index(Request $request)
    {
        $shops = Shop::where('owner_id', auth()->id())->with('branches')->orderBy('id', 'DESC');
        $page = $request->input('page') ? : 1;
        $take = $request->input('count') ? : 6;
        $count = $shops->count();


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
     * Store a newly created resource in storage.
     *
     * @param ShopRequest $request
     * @return ShopResource
     */
    public function store(ShopRequest $request)
    {
        $data = $request->all();
        $shop = Shop::create($data);

        if ($request->hasFile('logo')) {
            $shop->addMediaFromRequest('logo')->toMediaCollection('shop_logo', 'public');
        }


        $shop->branches()->createMany($data['branches']);

        return new ShopResource($shop);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return ShopResource
     */
    public function show($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->load('branches');

        return new ShopResource($shop);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShopRequest $request
     * @param $id
     * @return ShopResource
     */
    public function update(ShopRequest $request, $id)
    {
        $data = $request->all();
        $shop = Shop::create($data);
        $shop->branches()->createMany($data['branches']);

        return new ShopResource($shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);

        if ($shop) {
            $shop->delete();
            return response([
                "message" => "Shop deleted successfully!"
            ], 200);
        }
        return response([
            "message" => "Shop not found!"
        ], 400);
    }
}
