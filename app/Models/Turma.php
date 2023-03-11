<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
