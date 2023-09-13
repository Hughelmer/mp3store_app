<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function addToCart(Song $song)
    {
        $this->cartItems()->updateOrCreate(
            ['song_id' => $song->id],
            ['quantity' => $this->cartItems()->where('song_id', $song->id)->value('quantity') + 1]
        );
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function createOrder($orderTotal)
    {
        return $this->orders()->create(['order_total' => $orderTotal]);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
