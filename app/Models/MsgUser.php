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
}
