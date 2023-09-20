@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>

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
                            @if ($cartItem)
                                Product Type: {{ $cartItem->product_type }}<br>
                                @if ($cartItem->product_type === 'song' && $cartItem->song)
                                    Title: {{ $cartItem->song->title }}<br>
                                @elseif ($cartItem->product_type === 'album' && $cartItem->album)
                                    Title: {{ $cartItem->album->title }}<br>
                                @endif
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

        <p>Total: ${{ $cartItems->sum(function ($cartItem) { return $cartItem->price * $cartItem->quantity; }) }}</p>

        <form action="{{ route('cart.place-order') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>
    @endif
</div>
@endsection
