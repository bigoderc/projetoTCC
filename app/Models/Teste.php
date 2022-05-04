<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{   
    protected $table = 'testebd';
    protected $fillable = [
        'id',
        'nome',
        'hospital',
        'valor',
    ];

    public $timestamps = false;
}
