<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projeto extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'projetos';
    protected $fillable = [
        'id',
        'nome',
        'instituicao',
        'fk_professores_id',
        'apresentacao',
        'projeto',
        'fk_areas_id'
    ];
    public function professor(){
        return $this->hasOne(Professor::class,'id','fk_professores_id')->withTrashed();
    }
    public function area(){
        return $this->hasOne(Area::class,'id','fk_areas_id')->withTrashed();
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
