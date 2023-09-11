@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Orders</h1>

    @if ($orders->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You haven't placed any orders yet.</p>
    @endif
</div>
@endsection
