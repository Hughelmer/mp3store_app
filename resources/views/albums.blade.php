@extends('layouts.app')

@section('content')
<div class="container">
    <div class="search-container">
        <h1>Discover Albums</h1>
        <form action="{{ route('albums.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search for albums" value="{{ $search }}">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="albums-list">
        @if (count($albums) > 0)
            <div class="row">
                @foreach ($albums as $album)
                    <div class="col-md-4">
                        <div class="album-card">
                            <h3>{{ $album->title }}</h3>
                            <!-- Display album details here -->
                            <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary">View Album</a>
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
