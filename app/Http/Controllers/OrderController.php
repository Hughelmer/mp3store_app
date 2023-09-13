<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
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

    public function store(Request $request)
    {

        $order = Order::create([
            'user_id' => auth()->user()->id,
        ]);

        $items = [];

        foreach ($request->input('song_ids') as $songId) {
            $items[] = [
                'song_id' => $songId,
                'quantity' => $request->input('quantities')[$songId], 
            ];
        }

        $order->items()->createMany($items);

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');

    }
}
