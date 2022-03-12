<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\User\ShopResource;
use App\Models\Shop;
use App\Models\ShopBranch;
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
        $shops = Shop::withTrashed()->where('owner_id', auth()->id())->with('branches');
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
     * Store a newly created resource in storage.
     *
     * @param ShopRequest $request
     * @return ShopResource
     */
    public function store(ShopRequest $request)
    {
        $data = $request->all();
        $data['owner_id'] = auth('user')->id();
        $shop = Shop::create($data);

        if ($request->hasFile('logo')) {
            $shop->addMediaFromRequest('logo')->toMediaCollection('shop_logo', 'public');
        }

        if ($data['branches'] && count($data['branches'])) {
            $shop->branches()->createMany($data['branches']);
        }

        return new ShopResource($shop);
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

    /**
     * @param Request $request
     * @param $id
     * @return ShopResource
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('branches', 'logo');
        $shop = Shop::withTrashed()->where('id', $id);
        $shop->update($data);

        $shop = $shop->first();
        if ($request->hasFile('logo')) {
            $shop->media()->delete();
            $shop->addMediaFromRequest('logo')->toMediaCollection('shop_logo', 'public');
        }

        $branches = $request->branches;
        if ($branches && count($branches)) {
            $shop->branches()->createMany($branches);
        }

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
        $shop = Shop::withTrashed()->findOrFail($id);

        $deleteType = null;

        if(!$shop->trashed()){
            $shop->delete();
            $deleteType = 'delete';
        }
        else {
            $deleteType = 'forceDelete';
            $shop->forceDelete();
        }

        return response()->json([
            'status' => true,
            'deleteType' => $deleteType,
            'message' => 'Shop has been deleted successfully!'
        ], 200);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {

        $shop = Shop::withTrashed()->findOrFail($id);

        $shop->restore();

        return response()->json([
            'status'   => true,
            'data' => new ShopResource($shop),
            'message'  => 'Shop has been restored successfully!'
        ], 200);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteShopBranch($id)
    {
        $shop = ShopBranch::findOrFail($id);
        $shop->delete();

        return response()->json([
            'status' => true,
            'message' => 'Shop branch has been deleted successfully!'
        ], 200);
    }

}
