<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Artist extends Model
{
    use HasFactory; 

    public $timestamps = false;

    protected $fillable = [
        'name',
        'nationality',
        'image',
        'description',
        'is_band'
    ];

    function member()
    {
        return $this->hasMany(Member::class);
    }


    function album()
    {
        return $this->hasMany(Album::class);
    }
}
