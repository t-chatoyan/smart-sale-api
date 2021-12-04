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
     * Display a listing of the shop.
     *
     * @return ShopResource
     */
    public function index(Request $request)
    {
        $shops = Shop::with('branches')->orderBy('id', 'DESC');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return ShopResource
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        $shop->load('branches');

        return new ShopResource($shop);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
