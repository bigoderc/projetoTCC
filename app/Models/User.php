<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles)
    {
        if (is_array($roles) || is_object($roles)) {
            return !!$roles->intersect($this->roles)->count();
        }

        return $this->roles->contains('nome', $roles);
    }
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class,'role_users', 'fk_users_id', 'fk_roles_id')->withPivot(['id']);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id_created = auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->user_id_updated = auth()->user()->id;
            }
        });
    }
    public function aluno(){
        return $this->hasOne(Aluno::class,'fk_user_id','id')->withTrashed();
    }
    public function professor(){
        return $this->hasOne(Professor::class,'fk_user_id','id')->withTrashed();
    }
}
