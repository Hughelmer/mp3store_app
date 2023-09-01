<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'cover_image',
        // Add more fillable fields here
    ];

    // Relationship with Artist
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    // Relationship with Songs
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
