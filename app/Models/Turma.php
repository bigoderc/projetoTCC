<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;
    protected $table = 'turmas';
    protected $fillable = [
        'nome',
        'descricao',
        'fk_curso_id'
    ];
    public function curso(){
        return $this->hasOne(Curso::class,'id','fk_curso_id');
    }
}
