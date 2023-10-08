<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocorrencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ocorrencias';

    protected $fillable = [
        'colaborador',
        'empresa',
        'content',
        'status',
        'titulo',
        'views',
        'template',
        'update_user'
    ];

    protected $dates = ['deleted_at']; // marca a coluna como uma data

    /**
     * Scopes
    */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }
    
    /**
     * Relacionamentos
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'colaborador', 'id');
    }

    public function empresaObject()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresa');
    }

    public function comentariosCount()
    {
        return $this->hasMany(ComentarioOcorrencia::class, 'ocorrencia', 'id')->count();
    }

    public function visualizacoes()
    {
        return $this->hasMany(UserOcorrencia::class, 'ocorrencia', 'id');
    }

    /**
     * Scopes
    */
    public function search($filter = null)
    {
        $results = Ocorrencia::select('ocorrencias.id', 'ocorrencias.status', 'ocorrencias.empresa', 'ocorrencias.colaborador', 'ocorrencias.titulo', 'ocorrencias.content')
                                ->leftJoin('users', function ($query) use ($filter)
                                {
                                    $query->on('ocorrencias.colaborador', '=', 'users.id');
                                })
                                ->where('ocorrencias.titulo', 'LIKE', "%{$filter}%")
                                ->orWhere('ocorrencias.content', 'LIKE', "%{$filter}%")
                                ->orWhere('users.name', 'LIKE', "%{$filter}%")
                                ->paginate(25);
                        
        return $results;
                        
    }
}
