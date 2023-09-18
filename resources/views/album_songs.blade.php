@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Songs from {{ $album->title }}</h1>

    <div class="song-list">
        @foreach ($songs as $song)
        <div class="song-card">
            <h3>{{ $song->title }}</h3>
            <p>Artist: {{ $song->artist->name }}</p>
            <audio controls>
                <source src="{{ $song->audio_url }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <form action="{{ route('cart.add', $song->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
