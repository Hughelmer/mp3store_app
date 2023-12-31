@extends('layouts.app')

@section('content')
<div class="container">
    <div class="search-container">
        <h1>Discover Albums</h1>
        <form action="{{ route('albums.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search for albums">
            <button type="submit">Search</button>
        </form>
    </div>

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

    <div class="albums-list">
        @if (count($albums) > 0)
            <div class="row">
                @foreach ($albums as $album)
                    <div class="col-md-4 mb-4">
                        <div class="album-card">
                            @if ($album->cover_image)
                                <img src="{{ asset($album->cover_image) }}" class="card-img-top" alt="{{ $album->title }}">
                            @else
                                <img src="{{ asset('storage/img/default-img.png') }}" class="card-img-top" alt="Default Image">
                            @endif

                            <h3>Album Title: {{ $album->title }}</h3>
                            @if ($album->artist)
                                <p class="card-text">Artist: {{ $album->artist->name }}</p>
                            @else
                                <p class="card-text">Unknown Artist</p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary">View Album</a>
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        <form action="{{ route('albums.destroy', $album) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ml-2">Delete Album</button>
                                        </form>
                                    @else
                                        <form action="{{ route('cart.addAlbum', $album->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Add to Cart</button>
                                        </form>
                                        <a href="{{ route('cart.index') }}" class="btn btn-success">Checkout</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No albums found</p>
        @endif
    </div>
</div>

@endsection
