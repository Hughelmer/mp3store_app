@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $song->title }}</h1>
            <p>Artist: {{ $song->artist->name }}</p>
            <p>Album: {{ $song->album->title }}</p>
            <p>Duration: {{ $song->duration }} minutes</p>
            <p>Price: ${{ $song->price }}</p>

            <!-- Debugging output: -->
            <p>Audio File Path: {{ $song->audio_file }}</p>
            <p>Generated URL: {{ asset($song->audio_file) }}</p>
            
            <audio controls>
                <source src="{{ asset($song->audio_file) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <div class="col-md-6">
            @if (Auth::user() && Auth::user()->isAdmin())
                <form action="{{ route('song.destroy', $song) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @else
                <form action="{{ route('cart.add', $song) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
                <a href="{{ route('cart.checkout') }}" class="btn btn-success">Checkout</a>
            @endif
        </div>
    </div>
</div>
@endsection
