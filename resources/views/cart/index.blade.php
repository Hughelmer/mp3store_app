@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>

    @if (count($cartItems) === 0)
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
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
                        <td>${{ $cartItem->price }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartItem) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Total: ${{ $cartItems->sum(function ($cartItem) { return $cartItem->song->price * $cartItem->quantity; }) }}</p>

        <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
    @endif
</div>
@endsection
