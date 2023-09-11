<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Song;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'song_id',
        'quantity',
        'price',

        // Add any other fillable fields here
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('song_id');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
        });
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

}
