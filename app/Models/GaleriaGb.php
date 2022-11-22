<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GaleriaGb extends Model
{
    use HasFactory;

    protected $table = 'galeria_gbs'; 

    protected $fillable = [
        'galeria',
        'path',
        'cover'
    ];

    /**
     * Accerssors and Mutators
    */
    public function getUrlCroppedAttribute()
    {
        return Storage::url($this->path);
    }

    public function getUrlImageAttribute()
    {
        return Storage::url($this->path);
    }
}
