<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'fk_tema_id',
        'fk_area_id'
    ];
}
