<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasPermission(Permission $permissao){
        return $this->hasAnyRoles($permissao->roles);
    }

    public function hasAnyRoles($regras){
        //dd($regras);
        if(is_array($regras) || is_object($regras)){

            return !! $regras->intersect($this->roles)->count();
        }
        //dd('sdfsdf');
        //checar se tem um usuario com uma regra so
        return $this->roles->contains('nome', $regras);
    }
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class,'role_users', 'fk_users_id', 'fk_roles_id');
    }
}
