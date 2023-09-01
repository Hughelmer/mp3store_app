<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongCode extends Model
{
    protected $fillable = [
        'code',
        // Add more fillable fields here
    ];

    // Relationship with Song
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
