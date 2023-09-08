<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\OrderItem;

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

        // Create a new order
        $order = Order::create([
            'user_id' => auth()->user()->id, // Assuming orders are associated with users
            // Add more fields here as needed
        ]);

        // Create order items based on the cart items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'song_id' => $cartItem->song_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->song->price,
            ]);
        }

        // Clear the user's cart
        auth()->user()->cartItems()->delete();

        // Redirect to the order details page
        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully.');
    }

}
