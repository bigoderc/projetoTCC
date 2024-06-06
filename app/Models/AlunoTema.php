<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoTema extends Model
{
    use HasFactory;
    protected $table = 'alunos_tema';
    protected $fillable = [
        'fk_alunos_id',
        'fk_tema_id',
        'fk_professores_id',
        'deferido',
        'justificativa',
        'defendido'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id_created = auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->user_id_updated = auth()->user()->id;
            }
        });
    }
    public function professor(){
        return $this->hasOne(Professor::class,'id','fk_professores_id')->withTrashed();
    }
    public function aluno(){
        return $this->hasOne(Aluno::class,'id','fk_alunos_id')->withTrashed();
    }
    public function getStatusDescAttribute(){
        $status = 'Aguardando';
        if($this->attributes['defendido'] == true){
            $status = 'Defendido';
        }elseif($this->attributes['deferido'] == false){
            $status = 'Indeferido';
        }elseif($this->attributes['deferido'] == true){
            $status = 'Deferido';
        }
        return $status;
    }
    protected $appends = ['status_desc'];
}
