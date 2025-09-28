<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class WishlistResource extends JsonResource
{
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'attributes' => [
                'user_id' => $this->user_id,
                'product_id' => $this->product_id,
                'product' => $this->product,
                'user' => $this->user,
                'created_at' => $this->created_at,
            ],
        ];
    }
}
