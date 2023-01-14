<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsgUser extends Model
{
    use HasFactory;

    protected $table = 'msg_users';

    protected $fillable = [
        'user',
        'remetente',
        'resp_id',
        'titulo',
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
    public function children()
    {
        return $this->hasMany(MsgUser::class, 'resp_id', 'id');
    }

    public function colaborador()
    {
        return $this->hasOne(User::class, 'id', 'remetente');
    }

    /**
     * Accerssors and Mutators
    */
    
}
