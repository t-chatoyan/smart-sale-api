<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'uuid' => $this->uuid,
            'url' => $this->getUrl(),
            'id' => $this->id,
            'conversions' => [
                'small' => $this->getUrl('small'),
                'medium' => $this->getUrl('medium')
            ]
        ];
    }
}
