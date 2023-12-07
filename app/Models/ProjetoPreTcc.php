<?php

namespace App\Models;

use App\Helpers\Helper;
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
        'fk_areas_id',
        'aluno'
    ];
    public function professor(){
        return $this->hasOne(Professor::class,'id','fk_professores_id')->withTrashed();
    }
    public function area(){
        return $this->hasOne(Area::class,'id','fk_areas_id')->withTrashed();
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
        return $this->hasOne(Professor::class,'id','fk_aluno_id')->withTrashed();
    }
    public function getStorageAttribute()
    {
        $caminho = Helper::url('projetos');
        $path = $this->attributes['projeto'];

        // Use $path se estiver definido e não vazio, caso contrário, use $name
        return $this->attributes['storage'] = $caminho . $path;
    }
    public function getApresentadoDescAttribute()
    {
        try {
            //code...
            $created = Carbon::parse($this->attributes['apresentacao']);
            $created->setTimezone('America/Sao_Paulo');
            return $this->attributes['apresentado_desc'] =  $created->format('d/m/Y');
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
        
        
    }
    protected $appends = ['storage','apresentado_desc'];
}
