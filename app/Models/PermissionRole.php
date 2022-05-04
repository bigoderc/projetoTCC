<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;
    protected $table = 'permission_roles';
    protected $fillable = [
        'id',
        'fk_roles_id',
        'fk_permission_id'
    ];
}
