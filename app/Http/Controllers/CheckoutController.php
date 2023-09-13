<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems;
        $orderTotal = $cartItems->sum('song.price');

        return view('checkout.index', compact('cartItems', 'orderTotal'));
        
    }

    public function store()
    {
        $cartItems = auth()->user()->cartItems;
        $orderTotal = $cartItems->sum('song.price');

        $order = Order::create([
            'user_id' => auth()->user()->id, 
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'song_id' => $cartItem->song_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->song->price,
            ]);
        }

        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully.');

    }

}
