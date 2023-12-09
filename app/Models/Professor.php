<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'professores';
    protected $fillable = [
        'id',
        'nome',
        'siape',
        'fk_areas_id',
        'fk_grau_id',
        'fk_especialidade_id',
        'fk_user_id'
    ];

    public $timestamps = false;
    
    public function area(){
        return $this->hasOne(Area::class,'id','fk_areas_id')->withTrashed();
    }
    public function especialidade(){
        return $this->hasOne(Especialidade::class,'id','fk_especialidade_id')->withTrashed();
    }
    public function grau(){
        return $this->hasOne(Grau::class,'id','fk_grau_id')->withTrashed();
    }
    
    public function user(){
        return $this->hasOne(User::class,'id','fk_user_id')->withTrashed();
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
}
