<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Album;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Song;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems;
        $orderTotal = $cartItems->sum('price');

        return view('checkout.index', compact('cartItems', 'orderTotal'));
    }

    public function addSong($id)
    {
        $user = auth()->user();
        $productType = 'song';
        $product = Song::find($id);

        if (!$product) {
            return back()->with('error', 'Song not found.');
        }

        $cartItem = $user->cartItems()->where([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_type' => $productType,
        ])->first();

        if ($cartItem) {
            return back()->with('info', 'Song is already in the cart.');
        } else {
            $cartItem = new CartItem([
                'user_id' => $user->id,
                'quantity' => 1,
                'price' => $product->price,
                'product_type' => $productType,
                'product_id' => $product->id,
                'song_id' => $productType === 'song' ? $product->id : null,
                'album-id' => $productType === 'album' ? $product->id : null,

            ]);
        }

        $cartItem->save();

        return back()->with('success', 'Song added to cart.');
    }

    public function addAlbum($id)
    {
        $user = auth()->user();
        $productType = 'album';
        $album = Album::find($id);

        if (!$album) {
            return back()->with('error', 'Album not found.');
        }

        $cartItem = $user->cartItems()->where([
            'user_id' => $user->id,
            'product_id' => $album->id,
            'product_type' => $productType,
        ])->first();

        if ($cartItem) {
            return back()->with('info', 'Album is already in the cart.');
        } else {
            $cartItem = new CartItem([
                'user_id' => $user->id,
                'quantity' => 1,
                'price' => $album->price,
                'product_type' => $productType,
                'product_id' => $album->id,
                'song_id' => $productType === 'song' ? $album->id : null,
                'album_id' => $productType === 'album' ? $album->id : null,
            ]);
        }
        $cartItem->save();

        return back()->with('success', 'Album added to cart.');
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

}
