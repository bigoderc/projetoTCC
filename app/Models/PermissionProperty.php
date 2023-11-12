<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_permission_id',
        'acao',
        'fk_role_id'
    ];

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Permission::class,'permissions','fk_permission_id')->withPivot(['id']);

    }
}
