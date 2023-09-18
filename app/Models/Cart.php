<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{   
    protected $table = 'cart_items';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class, 'product_id');
    }

    public function album()
    {
    return $this->belongsTo(Album::class);
    }

}
