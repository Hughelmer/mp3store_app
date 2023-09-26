<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Song;
use App\Models\OrderItem;

class SongPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function download(User $user, Song $song){
        $orderItem = OrderItem::where('song_id', $song->id)->first();

        if($orderItem && $orderItem->order->user_id === $user->id){
            return true;
        }

        return false;
    }
}
