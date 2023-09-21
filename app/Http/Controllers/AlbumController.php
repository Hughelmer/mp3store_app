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
            $albums = [];
        }

        return view('albums', compact('albums', 'search'));
    }

    public function show($id)
    {
        $album = Album::findOrFail($id);

        return view('albums.show', compact('album'));
    }

    public function destroy(Album $album)
    {
        $album->songs()->delete();

        $album->delete();

        return redirect()->route('home')->with('success', 'Album and associated songs deleted successfully');
    }
}
