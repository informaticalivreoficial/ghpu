<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcorrenciaTemplate extends Model
{
    use HasFactory;

    protected $table = 'ocorrencia_templates';

    protected $fillable = [
        'autor',
        'empresa',
        'content',
        'status',
        'titulo',
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
    public function userObject()
    {
        return $this->hasOne(User::class, 'id', 'autor');
    }
    
    public function empresaObject()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresa');
    }
}
