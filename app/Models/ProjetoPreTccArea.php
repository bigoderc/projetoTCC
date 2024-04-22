<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoPreTccArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'fk_projeto_pre_tcc_id',
        'fk_area_id'
    ];
}
