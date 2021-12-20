<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
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
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => asset($this->image),
            'total_sold' => $this->total_sold,
            'price' => $this->price,
            'sub_images' => ProductImageResource::collection($this->productImages),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
