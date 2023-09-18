@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <h1>Checkout</h1>

    @if (count($cartItems) === 0)
        <p>Your cart is empty. Nothing to checkout.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Song</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orderTotal = 0; // Initialize the total variable
                @endphp

                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->song->title }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ $cartItem->song->price }}</td>
                    </tr>
                    
                    @php
                        // Calculate the subtotal for this item and add it to the total
                        $subtotal = $cartItem->quantity * $cartItem->song->price;
                        $orderTotal += $subtotal;
                    @endphp
                @endforeach
            </tbody>
        </table>

        <p>Total: ${{ number_format($orderTotal, 2) }}</p>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    @endif
</div> -->


<div class="container">
    <h1>Checkout</h1>

    @if (count($cartItems) === 0)
        <p>Your cart is empty. Nothing to checkout.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orderTotal = 0; // Initialize the total variable
                @endphp

                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>
                            @if ($cartItem->product_type === 'song' && $cartItem->song)
                                {{ $cartItem->song->title }}
                            @elseif ($cartItem->product_type === 'album' && $cartItem->album)
                                {{ $cartItem->album->title }}
                            @else
                                Product Not Found
                            @endif
                        </td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>
                            @if ($cartItem->product_type === 'song' && $cartItem->song)
                                ${{ $cartItem->song->price }}
                            @elseif ($cartItem->product_type === 'album' && $cartItem->album)
                                ${{ $cartItem->album->price }}
                            @endif
                        </td>
                    </tr>
                    
                    @php
                        // Calculate the subtotal for this item and add it to the total
                        if ($cartItem->product_type === 'song' && $cartItem->song) {
                            $subtotal = $cartItem->quantity * $cartItem->song->price;
                        } elseif ($cartItem->product_type === 'album' && $cartItem->album) {
                            $subtotal = $cartItem->quantity * $cartItem->album->price;
                        } else {
                            $subtotal = 0; // Handle the case when the product is not found
                        }
                        $orderTotal += $subtotal;
                    @endphp
                @endforeach 
            </tbody>
        </table>

        <p>Total: ${{ number_format($orderTotal, 2) }}</p>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    @endif
</div>
@endsection
