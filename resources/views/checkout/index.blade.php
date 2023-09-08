@extends('layouts.app')

@section('content')
<div class="container">
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
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->song->title }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ $cartItem->song->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Total: ${{ $orderTotal }}</p>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    @endif
</div>
@endsection
