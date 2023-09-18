<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',
        'song_id',
        'album_id',
        'quantity',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->morphTo();
    }

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

}
