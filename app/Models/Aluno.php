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
        'email'
    ];
    public function curso(){
        return $this->hasOne(Curso::class,'id','fk_curso_id');
    }
    public function turma(){
        return $this->hasOne(Turma::class,'id','fk_turma_id');
    }
    protected $appends = ['matriculado_desc'];

    public function getMatriculadoDescAttribute() {
        return $this->matriculado_desc = $this->matriculado =='S'? 'Sim':'Não';
    }
}
