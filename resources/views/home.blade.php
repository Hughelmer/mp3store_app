@extends('layouts.app')

@section('content')
<div class="container">
    <div class="search-container">
        <h1>Discover Albums</h1>
        <form action="{{ route('album.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search for albums">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="album-list">
        @foreach ($albums as $album)
        <div class="album-card">
            <a href="{{ route('album.show', $album->id) }}">
                <img src="{{ $album->cover_image }}" alt="{{ $album->title }}">
                <h3>{{ $album->title }}</h3>
                <p>{{ $album->artist->name }}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
