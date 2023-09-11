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
                    <th>Song</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->song->title }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ $cartItem->song->price }}</td>
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
