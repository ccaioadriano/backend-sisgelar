<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class)->whereHas('roles', function ($query) {
            $query->where('name', 'org_admin');
        });
    }
}
