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

    <!-- Create Song Form -->
    <form action="{{ route('admin.createSong') }}" method="POST">
        @csrf
        <label for="song-title">Song Title:</label>
        <input type="text" id="song-title" name="title" required>
        <!-- Add more input fields for song details -->
        <button type="submit">Create Song</button>
    </form>
</div>
@endsection
