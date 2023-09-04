<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'artist_id',
        // Add more fillable fields here
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
