<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema extends Model
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
        'descricao',
        'fk_areas_id',
        'link',
        'arquivo'
    ];
    public function areas(){
        return $this->belongsToMany(Area::class,'tema_areas','fk_tema_id','fk_area_id')->withTrashed();
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
    public function criado(){
        return $this->hasOne(User::class,'id','user_id_created')->withTrashed();
    }
    public function temaAluno(){
        return $this->hasOne(AlunoTema::class,'fk_tema_id','id');
    }
    public function getCreatedAtAttribute()
    {
        $created = Carbon::parse($this->attributes['created_at']);
        $created->setTimezone('America/Sao_Paulo');
        return $created->format('d/m/Y');
    }
    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function getStorageAttribute()
    {
        $caminho = Helper::url('temas');
        $path = $this->attributes['arquivo'];

        // Use $path se estiver definido e não vazio, caso contrário, use $name
        return $this->attributes['storage'] = $caminho . $path;
    }
    protected $appends = ['storage'];
    
}
