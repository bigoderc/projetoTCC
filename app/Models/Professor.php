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
        'siape',
        'fk_areas_id',
        'fk_grau_id',
        'fk_especialidade_id',
        'fk_cargo_id',
        'fk_user_id'
    ];

    public $timestamps = false;
    
    public function areas(){
        return $this->hasOne(Area::class,'id','fk_areas_id');
    }
    public function especialidade(){
        return $this->hasOne(Especialidade::class,'id','fk_especialidade_id');
    }
    public function graus(){
        return $this->hasOne(Grau::class,'id','fk_grau_id');
    }
    public function cargo(){
        return $this->hasOne(Cargo::class,'id','fk_cargo_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','fk_user_id');
    }
    
}
