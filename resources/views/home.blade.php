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

    <div class="albums-list">
        @if (count($albums) > 0)
            <div class="row">
                @foreach ($albums as $album)
                    <div class="col-md-4 mb-4">
                        <div class="album-card">
                            @if ($album->cover_image)
                                <!-- Display the album cover image -->
                                <img src="{{ asset($album->cover_image) }}" class="card-img-top" alt="{{ $album->title }}">
                            @else
                                <!-- Provide a default image if no cover image is available -->
                                <img src="{{ asset('img/default-img.png') }}" class="card-img-top" alt="Default Image">
                            @endif

                            <h3>Album Title: {{ $album->title }}</h3>
                            @if ($album->artist)
                                <p class="card-text">Artist: {{ $album->artist->name }}</p>
                            @else
                                <p class="card-text">Unknown Artist</p>
                            @endif
                            <!-- Display album details here -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary">View Album</a>
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        <!-- Admin user: Show "Delete Album" button -->
                                        <form action="{{ route('albums.destroy', $album) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ml-2">Delete Album</button>
                                        </form>
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
