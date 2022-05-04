<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'fk_areas_id'
    ];
    public $timestamps = false;
    protected $with = ['areas'];
    public function areas(){
        return $this->hasOne(Area::class,'id','fk_areas_id');
    }
}
