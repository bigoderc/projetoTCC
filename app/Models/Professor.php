<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $table = 'professores';
    protected $fillable = [
        'id',
        'nome',
        'matricula',
        'fk_areas_id',
        'grau',
        'especialidade',
        'cargo'
    ];

    public $timestamps = false;
    protected $with = ['areas'];
    public function areas(){
        return $this->hasOne(Area::class,'id','fk_areas_id');
    }
}
