<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    use HasFactory;

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
}
