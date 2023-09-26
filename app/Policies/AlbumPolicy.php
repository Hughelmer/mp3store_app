<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Album;
use App\Models\OrderItem;

class AlbumPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function download(User $user, Album $album){
        $orderItem = OrderItem::where('album_id', $album->id)->first();

        if($orderItem && $orderItem->order->user_id === $user->id){
            return true;
        }

        return false;
    }
}
