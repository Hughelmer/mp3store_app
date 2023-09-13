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
        'duration',
        'price',
    ];

    protected $attributes = [
        'audio_file' => '',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function songCodes()
    {
        return $this->hasMany(SongCode::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

}
