<?php

namespace App\Http\Resources\User;

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
            '1c_id' => $this['1c_id'],
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'discount' => $this->discount,
            'in_stock' => $this->in_stock,
            'is_available' => $this->is_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'photos' => MediaResource::collection($this->media)
        ];
    }
}
