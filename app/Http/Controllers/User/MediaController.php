<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {
        $media = Media::findByUuid($uuid);
        if (!$media) {
            return response()->json([
                'status'   => false,
                'message'  => 'Media was not found!'
            ], 404);
        }

        if ($media->delete()) {
            return response()->json([
                'status'   => true,
                'message'  => 'Media has been deleted successfully!'
            ], 200);
        }

        return response()->json([
            'status'   => false,
            'message'  => 'Server Error!'
        ], 500);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function order(Request $request)
    {
        $data = $request->all();
        $className = 'App\\Models\\' . $data['model_name'];

        $model = $className::where('id', $data['model_id'])->first();
        $imagesCollection = $model->getMedia($data['collection_name']);

        foreach ($data['order'] as $order) {
            $media = $imagesCollection->where('id', $order['id'])->first();
            $media->order_column = $order['order'];
            $media->save();
        }

        return response()->json([
            'data' => $request->all()
        ]);

    }
}
