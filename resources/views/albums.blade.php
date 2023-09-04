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
            @foreach ($albums as $album)
                <div class="album-card">
                    <h3>{{ $album->title }}</h3>
                    <!-- Display album details here -->
                </div>
            @endforeach
        @else
            <p>No album found</p>
        @endif
    </div>
</div>
@endsection
