<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_type',
        'song_id',
        'album_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->morphTo('product');
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
