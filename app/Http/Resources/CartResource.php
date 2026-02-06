<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartResource extends JsonResource
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
            "cart_id" => $this->id,
            "product_id" => $this->product->id,
            "product_name" => $this->product->title,
            "product_price" => $this->product->price,
            "quantity" => $this->qty,
            "discount" => $this->product->discount . "%",
            "total" => $this->amount,
            "product_image" => asset(Storage::url($this->product->image))
        ];
    }
}
