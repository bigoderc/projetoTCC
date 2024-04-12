<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjetoPreTcc extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'nome',
        'instituicao',
        'fk_professores_id',
        'apresentacao',
        'projeto',
        'fk_aluno_id'
    ];
    public function professor(){
        return $this->hasOne(Professor::class,'id','fk_professores_id')->withTrashed();
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
    public function aluno(){
        return $this->hasOne(Aluno::class,'id','fk_aluno_id')->withTrashed();
    }
    public function getStorageAttribute()
    {
        $caminho = Helper::url('projetos-pre-tcc');
        $path = $this->attributes['projeto'];

        // Use $path se estiver definido e não vazio, caso contrário, use $name
        return $this->attributes['storage'] = $caminho . $path;
    }
    public function areas(){
        return $this->belongsToMany(Area::class,'projeto_pre_tcc_areas','fk_projeto_pre_tcc_id','fk_area_id')->withTrashed();
    }
    public function getAreasDescAttribute()
    {
        $areas_desc = '';
        $areas_nome = '';

        // Oculta temporariamente o relacionamento setores
        $this->makeVisible(['setores']);
        // Acesso ao relacionamento setores sem carregamento automático
        $areas = $this->areas()->get();

        // Restaura a visibilidade do relacionamento setore

        foreach ($areas as $area) {
            $areas_nome .= $area->nome . ',';
        }

        $areas_nome = rtrim($areas_nome, ', '); // Remover a última vírgula e espaço

        $areas_desc = $areas_nome;
        return $areas_desc;
    }
    protected $appends = ['storage','areas_desc'];
}
