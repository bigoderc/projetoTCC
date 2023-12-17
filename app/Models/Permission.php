<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = ['name', 'acao'];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles', 'fk_permission_id', 'fk_roles_id')->withPivot(['id']);
    }
    public function permissionRole()
    {
        return $this->hasMany(PermissionRole::class,'fk_permission_id', 'id');
    }
}
