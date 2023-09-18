<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems;
        $orderTotal = $cartItems->sum('price');

        return view('checkout.index', compact('cartItems', 'orderTotal'));
    }

}
