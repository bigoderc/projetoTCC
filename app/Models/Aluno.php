<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
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
        return $this->hasOne(Turma::class,'id','fk_curso_id');
    }
}
