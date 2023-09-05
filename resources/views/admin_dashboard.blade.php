<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    <!-- Create Album Form -->
    <form action="{{ route('admin.createAlbum') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="album-title">Album Title:</label>
        <input type="text" id="album-title" name="title" required>
        <label for="album-cover">Cover Image:</label>
        <input type="file" id="album-cover" name="cover_image" accept="image/*" required>
        <button type="submit">Create Album</button>
    </form>

    <!-- Create Artist Form -->
    <form action="{{ route('admin.createArtist') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="artist-name">Artist Name</label>
            <input type="text" class="form-control" id="artist-name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Artist</button>
    </form>

    <!-- Create Song Form -->
    <form action="{{ route('admin.createSong') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Song Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="artist_id">Select Artist:</label>
            <select name="artist_id" id="artist_id" required>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="audio_file">Audio File</label>
            <input type="file" class="form-control-file" id="audio_file" name="audio_file" accept=".mp3" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Song</button>
    </form>

</div>
@endsection
