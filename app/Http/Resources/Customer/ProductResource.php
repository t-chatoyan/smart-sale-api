<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'discount' => $this->discount,
            'in_stock' => $this->in_stock,
            'is_available' => $this->is_available,
            'owner' => $this->owner,
            'shop' => $this->shop,
            'photos' => MediaResource::collection($this->media),
            'categories' => CategoryResource::collection($this->categories),
            'created_at' => $this->created_at,
        ];
    }
}
