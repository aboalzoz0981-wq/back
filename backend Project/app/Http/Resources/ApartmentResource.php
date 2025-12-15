<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adderss'=>$this->address,
            'price'=>$this->cost,
            'space'=>$this->space,
            'rooms'=>$this->rooms
        ];
    }
}
