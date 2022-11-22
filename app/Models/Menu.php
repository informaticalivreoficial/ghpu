<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'post',
        'id_pai',
        'titulo',
        'tipo',
        'link',
        'target',
        'status',
        'url'
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
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'id', 'id_pai');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'id_pai', 'id');
    }

    public function PostObject()
    {
        return $this->hasOne(Post::class, 'id', 'post');
    }

    /**
     * Accerssors and Mutators
    */
    public function getStatusAttribute($value)
    {
        if(empty($value)){
            return null;
        }

        return ($value == '1' ? 'Sim' : 'Não');
    }
    
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function getTipoAttribute($value)
    {
        if(empty($value)){
            return null;
        }

        return ($value == 'pagina' ? 'Página' : 'URL');
    }

    public function setTargetAttribute($value)
    {
        $this->attributes['target'] = ($value == '1' ? 1 : 0);
    }
}
