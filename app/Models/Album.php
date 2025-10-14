<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory; 

    public $timestamps = false;

    protected $fillable = [
        'name',
        'cover',
        'year',
        'genre',
        'artist_id'
    ];

    function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    function song()
    {
        return $this->hasMany(Song::class);
    }

}
