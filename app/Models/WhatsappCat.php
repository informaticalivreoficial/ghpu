<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappCat extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_cats';

    protected $fillable = [
        'titulo',
        'status',
        'content',
        'sistema'
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
    public function whatsapp()
    {
        return $this->hasMany(Whatsapp::class, 'categoria', 'id');
    }

    /**
     * Accerssors and Mutators
    */
    public function getCreatedAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }
}
