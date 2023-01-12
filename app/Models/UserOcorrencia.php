<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOcorrencia extends Model
{
    use HasFactory;

    protected $table = 'user_ocorrencias';

    protected $fillable = [
        'user',
        'ocorrencia',
        'status'
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
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }
}
