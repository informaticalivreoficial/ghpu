<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $fillable = [
        'titulo',
        'galeria',
        'content',
        'slug',
        'views',
        'status'        
    ];

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
    public function images()
    {
        return $this->hasMany(GaleriaGb::class, 'galeria', 'id')->orderBy('cover', 'ASC');
    }

    public function countimages()
    {
        return $this->hasMany(GaleriaGb::class, 'galeria', 'id')->count();
    }

    /**
     * Accerssors and Mutators
    */

    public function getContentWebAttribute()
    {
        return Str::words($this->content, '20', ' ...');
    }
        
    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !Storage::disk()->exists($cover['path'])) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    }
    
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function setSlug()
    {
        if(!empty($this->titulo)){
            $post = Galeria::where('titulo', $this->titulo)->first(); 
            if(!empty($post) && $post->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->titulo) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->titulo);
            }            
            $this->save();
        }
    }
}
