<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        return view('artists.index', compact('artists'));
    }

    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        return view('artists.show', compact('artist'));
    }

    // Add methods for create, store, edit, update, and destroy as needed
}
