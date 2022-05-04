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
        'curso',
        'matriculado',
        'periodo',
        'turma',
        'ingresso', 
        'email'
    ];
    public $timestamps = false;
}
