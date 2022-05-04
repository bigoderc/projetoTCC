<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'role_users';
    protected $fillable = [
        'id',
        'fk_roles_id',
        'fk_users_id'
    ];
}
