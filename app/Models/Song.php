<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory; 

    public $timestamps = false;

    protected $fillable = [
        'name',
        'lyrics',
        'songwriter',
        'album_id'
    ];

    function album()
    {
        return $this->belongsTo(Album::class);
    }
}
