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
            "total_amt" => $this->Total_amt,
            "status" => $this->status,
            "payment_verification" => $this->veri_status,
            "payement_receipt" => asset(Storage::url($this->payement_receipt)),
        ];
    }
}
