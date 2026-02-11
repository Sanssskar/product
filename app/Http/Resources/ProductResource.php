<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "price" => $this->price,
            "discount_percent" => $this->discount."%",
            "discount_amount" => $this->price * $this->discount / 100,
            "discounted_price" => $this->discounted_price(),
            "image" => asset(Storage::url($this->image)),
            "category" => $this->category->title,
        ];
    }
}
