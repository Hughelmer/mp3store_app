<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title',
        'artist_id',
        'album_id', 
        'audio_file', 
        'duration'
        // Add more fillable fields here
    ];

    protected $attributes = [
        'audio_file' => '',
    ];

    // Relationship with Album
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Relationship with SongCodes
    public function songCodes()
    {
        return $this->hasMany(SongCode::class);
    }

    // Relationship with artist
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

}
