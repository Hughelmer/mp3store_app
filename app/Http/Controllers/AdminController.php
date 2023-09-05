<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;
use App\Models\Artist;

class AdminController extends Controller
{
    public function dashboard()
    {   
        $artists = Artist::all(); // Retrieve all artists from the database

        return view('admin_dashboard', compact('artists')); // Pass the artists variable to the view
    }

    public function createAlbum(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create album
        $album = Album::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Album created successfully');
    }

    public function createSong(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|numeric', // Make the duration field optional
            // Add more validation rules as needed
        ]);

        // Create song
        $song = Song::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');
    }

    public function storeSong(Request $request)
    {
        // Validate input for song creation
        $validatedData = $request->validate([
            'title' => 'required|string',
            'duration' => 'nullable|numeric', // Make the duration field optional
            // Add more validation rules as needed
        ]);

        // Create song
        $song = Song::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Song created successfully');
    }

    public function createArtist(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        // Create artist
        $artist = Artist::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Artist created successfully');
    }

}
