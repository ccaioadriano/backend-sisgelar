<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'contact' => ['phone' => $this->contact, 'email' => $this->email],
            'address' => $this->address,
            'description' => $this->description,
            'equipments' => EquipmentResource::collection($this->equipments),
        ];
    }
}
