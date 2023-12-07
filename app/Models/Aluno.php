<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'alunos';
    protected $fillable = [
        'id',
        'nome',
        'matricula',
        'instituicao',
        'fk_curso_id',
        'matriculado',
        'periodo',
        'fk_turma_id',
        'ingresso', 
        'email',
        'fk_user_id',
        'formado'
    ];
    public function curso(){
        return $this->hasOne(Curso::class,'id','fk_curso_id')->withTrashed();
    }
    public function turma(){
        return $this->hasOne(Turma::class,'id','fk_turma_id')->withTrashed();
    }
    protected $appends = ['matriculado_desc'];

    public function getMatriculadoDescAttribute() {
        return $this->matriculado_desc = $this->matriculado =='S'? 'Sim':'Não';
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
