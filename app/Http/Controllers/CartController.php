<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Song;

class CartController extends Controller
{
    public function add(Song $song)
    {
        auth()->user()->addToCart($song);

        return back()->with('success', 'Item added to cart.');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems;

        return view('cart.index', compact('cartItems'));
    }

    public function remove(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

}
