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
        if ($this->product_type === 'song') {
            return $this->belongsTo(Song::class, 'product_id');
        } elseif ($this->product_type === 'album') {
            return $this->belongsTo(Album::class, 'product_id');
        } else {
            return null;
        }
    }

    public function song()
    {
        return $this->belongsTo(Song::class, 'product_id')->where('product_type', 'song');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'product_id')->where('product_type', 'album');
    }

}
