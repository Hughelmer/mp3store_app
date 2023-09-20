@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <p>Order ID: {{ $order->id }}</p>
    <p>Order Date: {{ $order->created_at }}</p>

    <h2>Order Items</h2>
    <ul>
        @foreach ($order->items as $item)
            <li>
                @if ($item->product_type === 'song' && $item->song)
                    {{ $item->song->title }} - Quantity: {{ $item->quantity }}
                    (Price: ${{ $item->price }} each)
                @elseif ($item->product_type === 'album' && $item->album)
                    {{ $item->album->title }} - Quantity: {{ $item->quantity }}
                    (Price: ${{ $item->price }} each)
                @else
                    Unknown Product
                @endif
            </li>
        @endforeach
    </ul>

    <p>Total Price: ${{ $order->order_total }}</p>
</div>
@endsection
