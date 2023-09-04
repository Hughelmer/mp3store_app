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
        @foreach ($albums as $album)
        <div class="album-card">
            <a href="{{ route('albums.show', $album->id) }}">
                <h3>{{ $album->title }}</h3>
                <p>{{ $album->artist->name }}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
