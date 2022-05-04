<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class,'permission_roles','fk_permission_id','fk_roles_id')->withPivot(['id']);

    }
}
