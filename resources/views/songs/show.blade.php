@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $song->title }}</h1>
            <p>Artist: {{ $song->artist->name }}</p>
            <p>Album: {{ $song->album->title }}</p>
            <p>Price: ${{ $song->price }}</p>
            
            <audio controls>
                <source src="{{ Storage::url($song->audio_file) }}" type="audio/mpeg">
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
                <form action="{{ route('cart.addSong', $song->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
                <a href="{{ route('cart.index') }}" class="btn btn-success">Checkout</a>
            @endif
        </div>
    </div>
</div>
@endsection
