<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'professores';
    protected $fillable = [
        'id',
        'nome',
        'siape',
        'fk_areas_id',
        'fk_grau_id',
        'fk_especialidade_id',
        'fk_user_id',
        'disponibilidade',
        'curriculo_lattes'
    ];

    public $timestamps = false;
    
    public function area(){
        return $this->hasOne(Area::class,'id','fk_areas_id')->withTrashed();
    }
    public function linhaPesquisas(){
        return $this->belongsToMany(Area::class,'professor_linha_pesquisas','professor_id','linha_pesquisa_id')->withTrashed();
    }
    public function especialidade(){
        return $this->hasOne(Especialidade::class,'id','fk_especialidade_id')->withTrashed();
    }
    public function grau(){
        return $this->hasOne(Grau::class,'id','fk_grau_id')->withTrashed();
    }
    
    public function user(){
        return $this->hasOne(User::class,'id','fk_user_id')->withTrashed();
    }
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
    public function getLinhaPesquisaDescAttribute()
    {
        $areas_desc = '';
        $areas_nome = '';

        // Oculta temporariamente o relacionamento setores
        $this->makeVisible(['setores']);
        // Acesso ao relacionamento setores sem carregamento automático
        $areas = $this->linhaPesquisas()->get();

        // Restaura a visibilidade do relacionamento setore

        foreach ($areas as $area) {
            $areas_nome .= $area->nome . ',';
        }

        $areas_nome = rtrim($areas_nome, ', '); // Remover a última vírgula e espaço

        $areas_desc = $areas_nome;
        return $areas_desc;
    }
    protected $appends = ['linha_pesquisa_desc'];
}
