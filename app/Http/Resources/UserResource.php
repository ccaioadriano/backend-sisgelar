<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'roles' => $this->roles->pluck('name'),
        ];
    }
}
