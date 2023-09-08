@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>

    <p>Order ID: {{ $order->id }}</p>
    <p>Order Date: {{ $order->created_at }}</p>

    <h2>Order Items</h2>
    <ul>
        @foreach ($order->items as $item)
            <li>
                {{ $item->song->title }} - Quantity: {{ $item->quantity }}
                (Price: ${{ $item->song->price }} each)
            </li>
        @endforeach
    </ul>

    <p>Total Price: ${{ $order->total_price }}</p>
</div>
@endsection
