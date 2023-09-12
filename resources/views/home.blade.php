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

    <div class="row albums-list">
        @foreach ($albums as $album)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if ($album->cover_image)
                
                <img src="{{ asset($album->cover_image) }}" class="card-img-top" alt="{{ $album->title }}">
                @else
                
                <img src="{{ asset('img/default-img.png') }}" class="card-img-top" alt="Default Image">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $album->title }}</h5>
                    @if ($album->artist)
                        <p class="card-text">{{ $album->artist->name }}</p>
                    @else
                        <p class="card-text">Unknown Artist</p>
                    @endif
                    <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary">View Album</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
