<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {       
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /*public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->input('product_ids') as $productId) {
            $orderItem = new OrderItem([
                'product_id' => $productId,
                'quantity' => $request->input('quantities')[$productId], 
            ]);

            if ($request->input('product_type') === 'song') {
                $orderItem->product_type = 'song';
                $orderItem->price = $orderItem->product->price;
            } elseif ($request->input('product_type') === 'album') {
                $orderItem->product_type = 'album';
                $orderItem->price = $orderItem->product->price;
            }

            $order->items()->save($orderItem);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');
    }*/
}
