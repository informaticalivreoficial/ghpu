<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioOcorrencia extends Model
{
    use HasFactory;

    protected $table = 'comentario_ocorrencias';

    protected $fillable = [
        'user',
        'ocorrencia',
        'content',
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
    public function ocorrencia()
    {
        return $this->belongsTo(Ocorrencia::class, 'ocorrencia', 'id');
    }

    public function userObject()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
