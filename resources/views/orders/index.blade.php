@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Orders</h1>

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

    @if ($orders->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Title</th>
                    <th>Total Amount</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_type }}</td>
                            <td>
                                @if ($item->product_type === 'song' && $item->song)
                                    {{ $item->song->title }}
                                @elseif ($item->product_type === 'album' && $item->album)
                                    {{ $item->album->title }}
                                @else
                                    Product Not Found
                                @endif
                            </td>
                            <td>${{ number_format($order->order_total, 2) }}</td>
                            <td>
                                @if ($item->product_type === 'song' && $item->song)
                                    <a href="{{ route('download.song', $item->song->id) }}" class="btn btn-primary" download>Download Song</a>
                                @elseif ($item->product_type === 'album' && $item->album)
                                    <a href="{{ route('download.album', $item->album->id) }}" class="btn btn-primary" download>Download Album</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <p>You haven't placed any orders yet.</p>
    @endif
</div>
@endsection
