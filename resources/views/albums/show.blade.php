@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Album Details</h1>
    <h2>{{ $album->title }}</h2>
    <p>Artist: {{ $album->artist->name }}</p>
   
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3>Songs on this Album:</h3>
    <ul>
        @foreach ($album->songs as $song)
            <li><a href="{{ route('songs.view', $song->id) }}">{{ $song->title }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
