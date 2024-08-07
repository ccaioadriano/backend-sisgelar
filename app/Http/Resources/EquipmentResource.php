<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'brand' => $this->brand,
            'client' => $this->client,
            'disabled' => $this->disabled ? true : false,
            'branch' => [
                'branchId' => $this->branch->id,
                'name' => $this->branch->name,
                'contact' => ['phone' => $this->branch->contact, 'email' => $this->branch->email],
                'address' => $this->branch->address,
                'description' => $this->branch->description,
            ]
        ];
    }
}
