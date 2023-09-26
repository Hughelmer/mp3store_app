<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Song;

class CartController extends Controller
{
    public function add($type, $id)
    {
        $product = null;
        $product_id = null;
        $product_type = null;
        $song_id = null;
        $album_id = null;

        if ($type === 'song') {
            $product = Song::find($id);
            $product_id = $product->id;
            $product_type = 'song';
            $song_id = $product->id;
        } elseif ($type === 'album') {
            $product = Album::find($id);
            $product_id = $product->id;
            $product_type = 'album';
            $album_id = $product->id;
        }

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $cartItem = new CartItem([
            'user_id' => auth()->user()->id,
            'product_id' => $product_id,
            'product_type' => $product_type,
            'song_id' => $song_id,
            'album_id' => $album_id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $cartItem->save();

        return back()->with('success', 'Item added to cart.');
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems;

        return view('cart.index', compact('cartItems'));
    }

    public function placeOrder()
    {
        $user = auth()->user();
        $cartItems = $user->cartItems;

        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Nothing to order.');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'order_total' => $cartItems->sum('price'),
        ]);

        foreach ($cartItems as $cartItem) {
            $price = 0;
            $songId = null;
            $albumId = null;

            if ($cartItem->product_type === 'song' && $cartItem->song) {
                $price = $cartItem->song->price;
                $songId = $cartItem->song->id;
            } elseif ($cartItem->product_type === 'album' && $cartItem->album) {
                $price = $cartItem->album->price;
                $albumId = $cartItem->album->id;
            }
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_type' => $cartItem->product_type,
                'song_id' => $songId,
                'album_id' => $albumId,
                'quantity' => $cartItem->quantity,
                'price' => $price,
            ]);

            $cartItem->delete();
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

}
