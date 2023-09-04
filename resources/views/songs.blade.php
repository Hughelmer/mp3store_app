@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $song->title }}</h1>
    <p>Artist: {{ $song->artist->name }}</p>
    <p>Album: {{ $song->album->title }}</p>
    <p>Duration: {{ $song->duration }} minutes</p>
    <audio controls>
        <source src="{{ $song->audio_url }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <form action="{{ route('cart.add', $song->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Add to Cart</button>
    </form>
    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Checkout</a>
</div>
@endsection
