<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;
    protected $table = 'projetos';
    protected $fillable = [
        'id',
        'nome',
        'instituicao',
        'fk_professores_id',
        'apresentacao',
        'projeto'
    ];
    public $timestamps = false;
    protected $with = ['professor'];
    public function professor(){
        return $this->hasOne(Professor::class,'id','fk_professores_id');
    }
}
