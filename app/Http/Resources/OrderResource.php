<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
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
            "order id" => $this->id,
            "total_amt" => $this->Total_amt,
            "status" => $this->status,
            "payment_verification" => $this->veri_status,
            "payment_receipt" => asset(Storage::url($this->payment_receipt)),
            "items" => Order_ItemResource::collection($this->order_items),
        ];
    }
}
