<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $albums = Album::where('title', 'like', '%' . $search . '%')->get();
        } else {
            $albums = []; // Empty array when no search query is provided
        }

        return view('albums', compact('albums', 'search'));
    }


    public function show($id)
    {
        $album = Album::findOrFail($id);
        return view('albums.show', compact('album'));
    }

    public function viewSongs(Album $album)
    {
        $songs = $album->songs;
        return view('album_songs', compact('album', 'songs'));
    }

    // Add methods for create, store, edit, update, and destroy here
}
