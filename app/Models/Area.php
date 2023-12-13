<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
 
    /**
     * Opcional, informar a coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = [
        'nome',
        'descricao',
        'link',
        'arquivo'
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
    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function getStorageAttribute()
    {
        try {
            //code...
            $caminho = Helper::url('areas');
            $path = $this->attributes['arquivo'];

            // Use $path se estiver definido e não vazio, caso contrário, use $name
            return $this->attributes['storage'] = $caminho . $path;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
        
    }
    protected $appends = ['storage'];
}
